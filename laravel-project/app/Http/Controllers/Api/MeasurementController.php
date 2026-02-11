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
                                    "timestamp" => 1738803600,
                                    "value" => 63.2,
                                    "details" => [
                                        "metrics" => [
                                            "avg_weight" => 63.2,
                                            "height" => 175.0,
                                            "bmi" => 20.6,
                                            "bmi_status" => 2
                                        ],
                                        "records" => [
                                            [
                                                "id" => "uuid-string",
                                                "weight" => 63.2,
                                                "timestamp" => 1738803600,
                                                "attachment_url" => null
                                            ]
                                        ]
                                    ]
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
        $user = Auth::user();
        $range = $request->query('range', 'days');

        $unit = match($range) {
            'months' => 'month',
            'weeks'  => 'week',
            default  => 'day',
        };

        $start = now()->sub($unit, 6)->startOf($unit);
        $end = now()->endOf($unit);

        $height = Measurement::where('user_id', $user->id)->whereNotNull('height')->latest('recorded_at')->value('height');

        $data = Measurement::where('user_id', $user->id)
            ->whereBetween('recorded_at', [$start, $end])
            ->orderBy('recorded_at', 'asc')
            ->get()
            ->groupBy(fn($m) => $m->recorded_at->startOf($unit)->timestamp)
            ->map(fn($items, $timestamp) => [
                'label' => (int) $timestamp,
                'value' => round((float) $items->avg('weight'), 1),
                'details' => [
                    'metrics' => [
                        'avg_weight' => round((float) $items->avg('weight'), 1),
                        'height' => $height ? (float) $height : null,
                        'bmi' => ($bmi = ($items->avg('weight') > 0 && $height > 0) ? $items->avg('weight') / pow($height / 100, 2) : null) ? round($bmi, 1) : null,
                        'bmi_status' => $this->getBmiStatus($bmi),
                    ],
                    'records' => $items->map(fn($r) => [
                        'id' => $r->id,
                        'weight' => (float) $r->weight,
                        'timestamp' => $r->recorded_at->timestamp,
                        'attachment_url' => $r->attachment_url,
                    ])->values()->all(),
                ],
            ])->values()->all();

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
                                new OA\Property(property: "success", type: "boolean", example: true),
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

        Measurement::updateOrCreate(
            [
                'user_id' => $userId,
                'recorded_at' => $recordedAt,
            ],
            $data
        );

        return response()->json([
            'status' => 201,
            'success' => true,
        ], 201);
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
                                        new OA\Property(property: "recorded_at", type: "integer", example: 1738803600),
                                        new OA\Property(
                                            property: "metrics",
                                            properties: [
                                                new OA\Property(
                                                    property: "weight",
                                                    properties: [
                                                        new OA\Property(property: "value", type: "number", format: "float", example: 62.0),
                                                        new OA\Property(property: "status", type: "integer", example: 2),
                                                    ],
                                                    type: "object"
                                                ),
                                                new OA\Property(
                                                    property: "bmi",
                                                    properties: [
                                                        new OA\Property(property: "value", type: "number", format: "float", example: 21.4),
                                                        new OA\Property(property: "status", type: "integer", example: 2),
                                                    ],
                                                    type: "object"
                                                ),
                                                new OA\Property(
                                                    property: "body_fat",
                                                    properties: [
                                                        new OA\Property(property: "value", type: "number", format: "float", example: 14.3),
                                                        new OA\Property(property: "status", type: "integer", example: 2),
                                                    ],
                                                    type: "object"
                                                ),
                                                new OA\Property(
                                                    property: "fat_free_body_weight",
                                                    properties: [
                                                        new OA\Property(property: "value", type: "number", format: "float", example: 53.1),
                                                        new OA\Property(property: "status", type: "integer", example: 2),
                                                    ],
                                                    type: "object"
                                                ),
                                            ],
                                            type: "object"
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

        $metrics = [
            'weight' => [
                'value' => (float) $measurement->weight,
                'status' => $this->getBmiStatus($measurement->bmi),
            ],
            'bmi' => [
                'value' => (float) $measurement->bmi,
                'status' => $this->getBmiStatus($measurement->bmi),
            ],
            'body_fat' => [
                'value' => (float) $measurement->body_fat,
                'status' => $this->getBodyFatStatus($measurement->body_fat, optional($measurement->user)->gender),
            ],
            'fat_free_body_weight' => [
                'value' => (float) $measurement->fat_free_body_weight,
                'status' => $this->getBmiStatus($measurement->bmi),
            ],
        ];

        return $this->success([
            'id' => $measurement->id,
            'recorded_at' => $measurement->recorded_at->timestamp,
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
