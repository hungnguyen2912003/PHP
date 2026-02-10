<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Measurement;
use App\Http\Requests\Api\Measurement\StoreWeightRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
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
                $end   = now()->endOfDay();

                $data = $query->whereBetween('recorded_at', [$start, $end])
                    ->selectRaw('DATE(recorded_at) as label, ROUND(AVG(weight), 1) as value')
                    ->groupBy('label')
                    ->orderBy('label')
                    ->get();
                break;
            case 'weeks':
                $start = now()->subWeeks(6)->startOfWeek(); // Mon
                $end   = now()->endOfWeek();                // Sun

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
                $end   = now()->endOfMonth();

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
                $end   = now()->endOfDay();

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
        path: "/api/measurements/weights/daily-summary/{date}",
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
                                                new OA\Property(property: "bmi_value", type: "number", format: "float", example: 23.0),
                                                new OA\Property(property: "bmi_status", type: "string", example: "Normal")
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
                                                    new OA\Property(property: "time", type: "string", example: "10:00")
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
    public function dailySummary($date)
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
            ->get(['id', 'weight', 'height', 'recorded_at']);

        if ($records->isEmpty()) {
            return $this->error('No measurement record found for this date', 404);
        }

        $avgWeight = (float) $records->avg('weight');
        $avgHeight = (float) $records->avg('height');

        $weight = round($avgWeight, 1);
        $height = round($avgHeight, 1);

        $bmiValue = 0.0;
        $bmiStatus = 'Unknown';

        if ($height > 0) {
            $bmiValue = round($weight / pow($height / 100, 2), 1);
            $bmiStatus = $this->getBmiStatus($bmiValue);
        }

        // get records daily
        $items = $records->map(function ($r) {
            $w = (float) $r->weight;
            $h = (float) $r->height;

            return [
                'id' => $r->id,
                'weight' => round($w, 1),
                'height' => round($h, 1),
                'time' => Carbon::parse($r->recorded_at)->format('H:i')
            ];
        });

        return $this->success([
            'date' => $date,
            'summary' => [
                'avg_weight' => $weight,
                'avg_height' => $height,
                'bmi_value' => $bmiValue,
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
        description: "Measurement details with health metrics and UI thresholds",
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
                                        new OA\Property(
                                            property: "record",
                                            ref: "#/components/schemas/Measurement"
                                        ),
                                        new OA\Property(
                                            property: "metrics",
                                            properties: [
                                                new OA\Property(
                                                    property: "weight",
                                                    properties: [
                                                        new OA\Property(property: "value", type: "number", format: "float"),
                                                        new OA\Property(property: "unit", type: "string", example: "kg"),
                                                        new OA\Property(property: "status", type: "string"),
                                                        new OA\Property(property: "thresholds", type: "array", items: new OA\Items(type: "number"))
                                                    ]
                                                ),
                                                new OA\Property(
                                                    property: "bmi",
                                                    properties: [
                                                        new OA\Property(property: "value", type: "number", format: "float"),
                                                        new OA\Property(property: "status", type: "string"),
                                                        new OA\Property(property: "thresholds", type: "array", items: new OA\Items(type: "number"))
                                                    ]
                                                ),
                                                new OA\Property(
                                                    property: "body_fat",
                                                    properties: [
                                                        new OA\Property(property: "value", type: "number", format: "float", nullable: true),
                                                        new OA\Property(property: "status", type: "string", nullable: true),
                                                        new OA\Property(property: "thresholds", type: "array", items: new OA\Items(type: "number"))
                                                    ]
                                                ),
                                                new OA\Property(
                                                    property: "fat_free_weight",
                                                    properties: [
                                                        new OA\Property(property: "value", type: "number", format: "float", nullable: true),
                                                        new OA\Property(property: "status", type: "string", nullable: true),
                                                        new OA\Property(property: "thresholds", type: "array", items: new OA\Items(type: "number"))
                                                    ]
                                                )
                                            ]
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
        $user = $measurement->user;
        $weight = (float) $measurement->weight;
        $height = (float) $measurement->height; // cm
        
        // --- 1. BMI ---
        $bmiValue = 0.0;
        $bmiStatus = 'Unknown';
        $bmiThresholds = [18.5, 23.0, 25.0, 30.0];

        if ($height > 0) {
            $bmiValue = round($weight / pow($height / 100, 2), 1);
            $bmiStatus = $this->getBmiStatus($bmiValue);
        }

        // --- 2. Weight (Thresholds based on BMI for current height) ---
        $weightStatus = $bmiStatus;
        $weightThresholds = [];
        if ($height > 0) {
            $h2 = pow($height / 100, 2);
            $weightThresholds = [
                round(18.5 * $h2, 1),
                round(23.0 * $h2, 1),
                round(25.0 * $h2, 1),
                round(30.0 * $h2, 1),
            ];
        }

        // --- 3. Body Fat & Fat Free Weight ---
        $bodyFat = null;
        $bodyFatStatus = null;
        $bodyFatThresholds = [6.0, 13.0, 17.0, 25.0]; // Standard for UI slider

        $fatFreeWeight = null;
        $fatFreeStatus = null;
        $fatFreeThresholds = $weightThresholds; // Usually mirrors weight categories

        if ($user && $user->date_of_birth && $user->gender && $bmiValue > 0) {
            $age = $user->date_of_birth->age;
            
            if ($user->gender === 'male') {
                $bodyFat = (1.20 * $bmiValue) + (0.23 * $age) - 16.2;
                $bodyFatStatus = $this->getBodyFatStatus($bodyFat, 'male');
            } else {
                $bodyFat = (1.20 * $bmiValue) + (0.23 * $age) - 5.4;
                $bodyFatStatus = $this->getBodyFatStatus($bodyFat, 'female');
            }

            $bodyFat = max(0, round($bodyFat, 1));
            $fatFreeWeight = round($weight * (1 - $bodyFat / 100), 1);
            $fatFreeStatus = $weightStatus;
        }

        return $this->success([
            'record' => $measurement,
            'metrics' => [
                'weight' => [
                    'value' => round($weight, 1),
                    'unit' => 'kg',
                    'status' => $weightStatus,
                    'thresholds' => $weightThresholds
                ],
                'bmi' => [
                    'value' => $bmiValue,
                    'status' => $bmiStatus,
                    'thresholds' => $bmiThresholds
                ],
                'body_fat' => [
                    'value' => $bodyFat,
                    'status' => $bodyFatStatus,
                    'thresholds' => $bodyFatThresholds
                ],
                'fat_free_weight' => [
                    'value' => $fatFreeWeight,
                    'status' => $fatFreeStatus,
                    'thresholds' => $fatFreeThresholds
                ],
            ]
        ]);
    }

    private function getBodyFatStatus($value, $gender)
    {
        if ($gender === 'male') {
            if ($value < 6) return 'Essential Fat';
            if ($value < 13) return 'Athletes';
            if ($value < 17) return 'Fitness';
            if ($value < 25) return 'Acceptable';
            return 'Obesity';
        } else {
            // Female standards are higher
            if ($value < 13) return 'Essential Fat';
            if ($value < 20) return 'Athletes';
            if ($value < 24) return 'Fitness';
            if ($value < 31) return 'Acceptable';
            return 'Obesity';
        }
    }

    private function getBmiStatus($bmiValue)
    {
        if ($bmiValue <= 0) return 'Unknown';
        if ($bmiValue < 18.5) return 'Underweight';
        if ($bmiValue < 23) return 'Normal';
        if ($bmiValue < 25) return 'Overweight';
        return 'Obese';
    }
}
