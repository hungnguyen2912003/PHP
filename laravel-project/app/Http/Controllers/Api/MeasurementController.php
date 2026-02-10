<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Measurement;
use App\Http\Requests\Api\Measurement\StoreWeightRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use OpenApi\Attributes as OA;
class MeasurementController extends BaseApiController
{
    public function __construct()
    {
        // Explicit authorization handled in methods
    }

    /**
     * Get weight chart data for the authenticated user.
     */
    #[OA\Get(
        path: "/api/measurements/weights/chart/{range}",
        summary: "Lấy dữ liệu biểu đồ cân nặng",
        description: "Lấy dữ liệu biểu đồ thống kê cân nặng của người dùng đã đăng nhập.",
        operationId: "weightChart",
        tags: ["Measurements"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "range",
                in: "path",
                required: true,
                description: "Khoảng thời gian hiển thị",
                schema: new OA\Schema(type: "string", enum: ["days", "weeks", "months"], example: "days")
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: "Fetch successfully",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ApiResponse"),
                new OA\Schema(
                    example: [
                        "status" => 200,
                        "body" => [
                            "data" => [
                                [
                                    "label" => "06 Feb",
                                    "value" => 63.2
                                ],
                                [
                                    "label" => "07 Feb",
                                    "value" => 63.0
                                ],
                                [
                                    "label" => "08 Feb",
                                    "value" => 62.8
                                ]
                            ]
                        ]
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Unauthorized (missing/invalid/expired token)",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ErrorResponse"),
                new OA\Schema(
                    example: [
                        "status" => 401,
                        "body" => [
                            "errors" => []
                        ]
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: "default",
        description: "Server error",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ErrorResponse"),
                new OA\Schema(
                    example: [
                        "status" => 500,
                        "body" => [
                            "errors" => []
                        ]
                    ]
                )
            ]
        )
    )]
    public function weightChart($range = null)
    {
        $this->authorize('viewAny', Measurement::class);

        $range = $range ?? request('range', 'days');
        $user = Auth::user();

        $query = Measurement::query();
        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        switch ($range) {
            case 'days':
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                $data = $query->whereBetween('recorded_at', [$start, $end])
                    ->selectRaw('DATE(recorded_at) as label, ROUND(AVG(weight), 1) as value')
                    ->groupBy('label')
                    ->orderBy('label')
                    ->get();
                break;
            case 'weeks':
                $start = now()->subWeeks(6)->startOfWeek(); // Mon
                $end = now()->endOfWeek();                // Sun

                // Tính trung bình 1 ngày
                $daily = $query->whereBetween('recorded_at', [$start, $end])
                    ->selectRaw('DATE(recorded_at) as d, AVG(weight) as day_avg')
                    ->groupBy('d');

                // Tính trung bình theo tuần
                $data = \DB::query()->fromSub($daily, 'daily')
                    ->selectRaw('YEARWEEK(d, 1) as yw')
                    ->selectRaw('MIN(d) as start_date, MAX(d) as end_date')
                    ->selectRaw('ROUND(AVG(day_avg), 1) as value')
                    ->groupBy('yw')
                    ->orderBy('yw')
                    ->get();
                break;
            case 'months':
                $start = now()->subMonths(6)->startOfMonth();
                $end = now()->endOfMonth();

                // Tính trung bình 1 ngày
                $daily = $query->whereBetween('recorded_at', [$start, $end])
                    ->selectRaw('DATE(recorded_at) as d, AVG(weight) as day_avg')
                    ->groupBy('d');

                // Tính trung bình theo tháng
                $data = \DB::query()->fromSub($daily, 'daily')
                    ->selectRaw('DATE_FORMAT(d, "%Y-%m") as label')
                    ->selectRaw('MIN(d) as start_date, MAX(d) as end_date')
                    ->selectRaw('ROUND(AVG(day_avg), 1) as value')
                    ->groupBy('label')
                    ->orderBy('label')
                    ->get();
                break;
            default:
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                $data = $query->whereBetween('recorded_at', [$start, $end])
                    ->selectRaw('DATE(recorded_at) as label, ROUND(AVG(weight), 1) as value')
                    ->groupBy('label')
                    ->orderBy('label')
                    ->get();
                break;
        }

        return $this->success($data);
    }

    /**
     * Store a weight-only record.
     */
    #[OA\Post(
        path: "/api/measurements/weights",
        summary: "Create a new weight-only measurement",
        tags: ["Measurements"],
        security: [["bearerAuth" => []]],
        parameters: []
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\MediaType(
            mediaType: "multipart/form-data",
            schema: new OA\Schema(
                required: ["weight", "time"],
                properties: [
                    new OA\Property(property: "weight", type: "number", format: "float", example: 70.5),
                    new OA\Property(property: "time", type: "string", format: "time", example: "10:00"),
                    new OA\Property(property: "attachment", type: "string", format: "binary")
                ]
            )
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Weight record created successfully",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ApiResponse"),
                new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: "body",
                            properties: [
                                new OA\Property(
                                    property: "data",
                                    properties: [
                                        new OA\Property(property: "id", type: "string", format: "uuid"),
                                        new OA\Property(property: "user_id", type: "string", format: "uuid"),
                                        new OA\Property(property: "weight", type: "number", format: "float"),
                                        new OA\Property(property: "recorded_at", type: "string", format: "date-time"),
                                        new OA\Property(property: "attachment_url", type: "string", nullable: true),
                                    ]
                                )
                            ]
                        )
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 422,
        description: "Validation error",
        content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
    )]
    public function storeWeight(StoreWeightRequest $request)
    {
        $userId = auth()->id();
        $date = now()->toDateString();
        $recordedAt = $date . ' ' . $request->time . ':00';

        $data = [
            'user_id' => $userId,
            'weight' => $request->weight,
            'recorded_at' => $recordedAt,
        ];

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store($userId . '/measurements', 'public');
            $data['attachment_url'] = '/storage/' . $path;
        }

        $measurement = Measurement::updateOrCreate(
            [
                'user_id' => $userId,
                'recorded_at' => $recordedAt,
            ],
            $data
        );

        return $this->success($measurement, 201);
    }

    /**
     * Get a summary of metrics (Weight, Height, BMI) for a specific date.
     */
    #[OA\Get(
        path: "/api/measurements/weights/summary/{date}",
        summary: "Get daily summary metrics",
        tags: ["Measurements"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "date",
                in: "path",
                description: "Date for the summary (YYYY-MM-DD)",
                required: true,
                schema: new OA\Schema(type: "string", format: "date", example: "2026-02-09")
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: "Daily summary metrics",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ApiResponse"),
                new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: "body",
                            properties: [
                                new OA\Property(
                                    property: "data",
                                    properties: [
                                        new OA\Property(property: "date", type: "string", format: "date", example: "2026-02-09"),
                                        new OA\Property(
                                            property: "summary",
                                            properties: [
                                                new OA\Property(property: "avg_weight", type: "number", format: "float", example: 70.5),
                                                new OA\Property(property: "avg_height", type: "number", format: "float", example: 175.0),
                                                new OA\Property(property: "avg_bmi", type: "number", format: "float", example: 23.0),
                                            ]
                                        ),
                                        new OA\Property(
                                            property: "records",
                                            type: "array",
                                            items: new OA\Items(
                                                properties: [
                                                    new OA\Property(property: "id", type: "integer", example: 1),
                                                    new OA\Property(property: "weight", type: "number", format: "float", example: 70.5),
                                                    new OA\Property(property: "height", type: "number", format: "float", example: 175.0),
                                                    new OA\Property(property: "time", type: "string", example: "10:00"),
                                                    new OA\Property(property: "attachment_url", type: "string", nullable: true, example: "/storage/1/measurements/image.jpg")
                                                ]
                                            )
                                        )
                                    ]
                                )
                            ]
                        )
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: "No records found",
        content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
    )]
    public function summary($date)
    {
        $this->authorize('viewAny', Measurement::class);
        $user = Auth::user();

        if (!$date) {
            $date = now()->toDateString();
        }

        // get records in day
        $records = Measurement::where('user_id', $user->id)
            ->whereDate('recorded_at', $date)
            ->orderBy('recorded_at', 'desc')
            ->get(['id', 'weight', 'height', 'recorded_at', 'bmi', 'attachment_url']);

        if ($records->isEmpty()) {
            return $this->error('No measurement record found for this date', 404);
        }

        $avgWeight = (float) $records->avg('weight');
        $avgHeight = (float) $records->avg('height');
        $avgBMI = (float) $records->avg('bmi');

        // get records daily
        $items = $records->map(function ($r) {
            $w = (float) $r->weight;
            $h = (float) $r->height;

            return [
                'id' => $r->id,
                'weight' => round($w, 1),
                'height' => round($h, 1),
                'time' => Carbon::parse($r->recorded_at)->format('H:i'),
                'attachment_url' => $r->attachment_url
            ];
        });

        return $this->success([
            'date' => $date,
            'summary' => [
                'avg_weight' => round($avgWeight, 1),
                'avg_height' => round($avgHeight, 1),
                'avg_bmi' => round($avgBMI, 1),
            ],
            'records' => $items,
        ]);
    }

    /**
     * Get a specific measurement.
     */
    #[OA\Get(
        path: "/api/measurements/weights/{id}",
        summary: "Get a specific measurement",
        tags: ["Measurements"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string", format: "uuid")
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: "Measurement details matching UI requirements",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ApiResponse"),
                new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: "body",
                            properties: [
                                new OA\Property(
                                    property: "data",
                                    properties: [
                                        new OA\Property(property: "id", type: "string", format: "uuid"),
                                        new OA\Property(property: "recorded_at", type: "string", format: "date-time"),
                                        new OA\Property(property: "weight", type: "number", format: "float"),
                                        new OA\Property(property: "bmi", type: "number", format: "float"),
                                        new OA\Property(property: "body_fat", type: "number", format: "float", nullable: true),
                                        new OA\Property(property: "fat_free_body_weight", type: "number", format: "float", nullable: true)
                                    ]
                                )
                            ]
                        )
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: "Measurement not found",
        content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
    )]
    public function show(Measurement $measurement)
    {
        $this->authorize('view', $measurement);

        $height = (float) $measurement->height;
        $h_m = $height / 100; // cm -> m

        $metrics = [];

        // 1. Weight
        if (!is_null($measurement->weight)) {
            $metrics[] = [
                'key' => 'weight',
                'name' => 'Weight',
                'value' => (float) $measurement->weight,
                'thresholds' => [
                    round(18.5 * $h_m * $h_m, 2),
                    round(25 * $h_m * $h_m, 2),
                    round(30 * $h_m * $h_m, 2)
                ],
                'categories' => ['Underweight', 'Normal', 'Overweight', 'Obesity']
            ];
        }

        // 2. BMI
        if (!is_null($measurement->bmi)) {
            $metrics[] = [
                'key' => 'bmi',
                'name' => 'BMI',
                'value' => (float) $measurement->bmi,
                'thresholds' => [18.5, 25, 30],
                'categories' => ['Underweight', 'Normal', 'Overweight', 'Obesity']
            ];
        }

        // 3. Body Fat
        if (!is_null($measurement->body_fat)) {
            $metrics[] = [
                'key' => 'body_fat',
                'name' => 'Body Fat',
                'value' => (float) $measurement->body_fat,
                'thresholds' => [6, 13, 17, 25],
                'categories' => ['Essential Fat', 'Athletes', 'Fitness', 'Acceptable', 'Obesity']
            ];
        }

        // 4. Fat-free Body Weight
        if (!is_null($measurement->fat_free_body_weight)) {
            $metrics[] = [
                'key' => 'fat_free_body_weight',
                'name' => 'Fat-free Body Weight',
                'value' => (float) $measurement->fat_free_body_weight,
                'thresholds' => [
                    round(18.5 * $h_m * $h_m, 2),
                    round(25 * $h_m * $h_m, 2),
                    round(30 * $h_m * $h_m, 2)
                ],
                'categories' => ['Thin', 'Normal', 'Strong', 'Obesity']
            ];
        }

        return $this->success([
            'id' => $measurement->id,
            'recorded_at' => $measurement->recorded_at->format('l, Y M j'),
            'metrics' => $metrics
        ]);
    }
}
