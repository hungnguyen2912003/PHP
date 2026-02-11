<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Measurement;
use App\Http\Requests\Api\Measurement\StoreWeightRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use OpenApi\Attributes as OA;
use Illuminate\Http\Request;

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
        path: "/api/measurements/weights/chart",
        summary: "Lấy dữ liệu biểu đồ cân nặng",
        description: "Lấy dữ liệu biểu đồ thống kê cân nặng của người dùng đã đăng nhập.",
        operationId: "weightChart",
        tags: ["Measurements"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "range",
                in: "query",
                required: false,
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
    public function weightChart(Request $request)
    {
        $this->authorize('viewAny', Measurement::class);

        $range = $request->query('range', 'days');
        $user = Auth::user();

        $query = Measurement::query();
        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        switch ($range) {
            case 'days':
                $data = $query
                    ->where('recorded_at', '>=', now()->subDays(6)->startOfDay())
                    ->where('recorded_at', '<=', now()->endOfDay())
                    ->selectRaw('DATE(recorded_at) as label, ROUND(AVG(weight), 1) as value')
                    ->groupByRaw('DATE(recorded_at)')
                    ->orderByRaw('DATE(recorded_at)')
                    ->get();
                break;
            case 'weeks':
                $start = now()->subWeeks(6)->startOfWeek(); // Mon
                $end = now()->endOfWeek();                // Sun

                // Tính trung bình 1 ngày
                $daily = $query->whereBetween('recorded_at', [$start, $end])
                    ->selectRaw('DATE(recorded_at) as d, ROUND(AVG(weight), 1) as day_avg')
                    ->groupBy('d');

                // Tính trung bình theo tuần
                $data = \DB::query()->fromSub($daily, 'daily')
                    ->selectRaw('YEARWEEK(d, 1) as yw')
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
                    ->selectRaw('DATE(recorded_at) as d, ROUND(AVG(weight), 1) as day_avg')
                    ->groupBy('d');

                // Tính trung bình theo tháng
                $data = \DB::query()->fromSub($daily, 'daily')
                    ->selectRaw('DATE_FORMAT(d, "%Y-%m") as label')
                    ->selectRaw('ROUND(AVG(day_avg), 1) as value')
                    ->groupBy('label')
                    ->orderBy('label')
                    ->get();
                break;
            default:
                $data = $query
                    ->where('recorded_at', '>=', now()->subDays(6)->startOfDay())
                    ->where('recorded_at', '<=', now()->endOfDay())
                    ->selectRaw('DATE(recorded_at) as label, ROUND(AVG(weight), 1) as value')
                    ->groupByRaw('DATE(recorded_at)')
                    ->orderByRaw('DATE(recorded_at)')
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
        path: "/api/measurements/weights/summary",
        summary: "Get daily summary metrics",
        tags: ["Measurements"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "date",
                in: "query",
                description: "Date for the summary (YYYY-MM-DD)",
                required: false,
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
                                                new OA\Property(property: "avg_weight", type: "number", format: "float", example: 70.5, nullable: true),
                                                new OA\Property(property: "height", type: "number", format: "float", example: 175.0, nullable: true),
                                                new OA\Property(property: "bmi", type: "number", format: "float", example: 23.0, nullable: true),
                                                new OA\Property(property: "bmi_status", type: "integer", example: 1, nullable: true, description: "1: Normal, 2: Low, 3: High"),
                                            ]
                                        ),
                                        new OA\Property(
                                            property: "records",
                                            type: "array",
                                            items: new OA\Items(
                                                properties: [
                                                    new OA\Property(property: "id", type: "string", format: "uuid"),
                                                    new OA\Property(property: "weight", type: "number", format: "float", example: 70.5),
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
    public function summary(Request $request)
    {
        $this->authorize('viewAny', Measurement::class);
        $user = Auth::user();

        $date = $request->query('date', now()->toDateString());

        // get records in day
        $records = Measurement::where('user_id', $user->id)
            ->whereDate('recorded_at', $date)
            ->orderBy('recorded_at', 'desc')
            ->get(['id', 'weight', 'height', 'recorded_at', 'bmi', 'attachment_url']);

        $avgWeight = $records->avg('weight');

        // Latest height (overall)
        $latestHeightRecord = Measurement::where('user_id', $user->id)
            ->whereNotNull('height')
            ->orderBy('recorded_at', 'desc')
            ->first(['height']);
        
        $height = $latestHeightRecord?->height;
        $bmi = null;

        if (!is_null($avgWeight) && !is_null($height) && $height > 0) {
            $h_m = $height / 100;
            $bmi = $avgWeight / ($h_m * $h_m);
        }

        // BMI status logic
        $bmiStatus = $this->getBmiStatus($bmi);

        // get records daily
        $items = $records->map(function ($r) {
            $w = (float) $r->weight;

            return [
                'id' => $r->id,
                'weight' => round($w, 1),
                'time' => $r->recorded_at->format('H:i'),
                'attachment_url' => $r->attachment_url,
            ];
        });

        return $this->success([
            'date' => $date,
            'summary' => [
                'avg_weight' => !is_null($avgWeight) ? round((float) $avgWeight, 1) : null,
                'height' => !is_null($height) ? round((float) $height, 1) : null,
                'bmi' => !is_null($bmi) ? round((float) $bmi, 1) : null,
                'bmi_status' => $bmiStatus,
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
                                        new OA\Property(
                                            property: "metrics",
                                            type: "array",
                                            items: new OA\Items(
                                                properties: [
                                                    new OA\Property(property: "key", type: "string", example: "weight"),
                                                    new OA\Property(property: "value", type: "number", format: "float", example: 70.5),
                                                    new OA\Property(property: "status", type: "integer", example: 2, nullable: true, description: "1: Low, 2: Normal, 3: High"),
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
        description: "Measurement not found",
        content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
    )]
    public function show(Measurement $measurement)
    {
        $this->authorize('view', $measurement);

        $metrics = [];

        // 1. Weight
        if (!is_null($measurement->weight)) {
            $metrics[] = [
                'weight' => [
                    'value' => (float) $measurement->weight,
                    'status' => $this->getBmiStatus($measurement->bmi),
                ]
            ];
        }

        // 2. BMI
        if (!is_null($measurement->bmi)) {
            $metrics[] = [
                'bmi' => [
                    'value' => (float) $measurement->bmi,
                    'status' => $this->getBmiStatus($measurement->bmi),
                ]
            ];
        }

        // 3. Body Fat (by gender)
        if (!is_null($measurement->body_fat)) {
            $metrics[] = [
                'body_fat' => [
                    'value' => (float) $measurement->body_fat,
                    'status' => $this->getBodyFatStatus($measurement->body_fat, optional($measurement->user)->gender),
                ]
            ];
        }

        // 4. Fat-free Body Weight
        if (!is_null($measurement->fat_free_body_weight)) {
            $metrics[] = [
                'fat_free_body_weight' => [
                    'value' => (float) $measurement->fat_free_body_weight,
                    'status' => $this->getBmiStatus($measurement->bmi),
                ]
            ];
        }

        return $this->success([
            'id' => $measurement->id,
            'recorded_at' => $measurement->recorded_at->format('Y-m-d'),
            'metrics' => $metrics
        ]);
    }

    /**
     * Get BMI status code (1: Low, 2: Normal, 3: High)
     */
    private function getBmiStatus(?float $bmi): ?int
    {
        if (is_null($bmi)) return null;

        if ($bmi < 18.5) {
            return 1; // Low
        } elseif ($bmi < 25) {
            return 2; // Normal
        } else {
            return 3; // High
        }
    }

    /**
     * Get Body Fat status code (1: Low, 2: Normal, 3: High)
     */
    private function getBodyFatStatus(?float $bodyFat, ?string $gender): ?int
    {
        if (is_null($bodyFat)) return null;

        if ($gender === 'female') {
            if ($bodyFat < 14) return 1; // Low
            if ($bodyFat < 32) return 2; // Normal
            return 3; // High
        } elseif ($gender === 'male') {
            if ($bodyFat < 6) return 1; // Low
            if ($bodyFat < 25) return 2; // Normal
            return 3; // High
        }

        return null;
    }
}
