<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Measurement;
use App\Http\Requests\Api\Measurement\StoreWeightRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MeasurementController extends BaseApiController
{

    /**
     * Get weight chart data for the authenticated user.
     */
    public function weightChart(Request $request)
    {
        $this->authorize('viewAny', Measurement::class);
        $user = Auth::user();
        $range = $request->query('range', 'days');

        $unit = match ($range) {
            'months' => 'month',
            'weeks' => 'week',
            default => 'day',
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
        if (is_null($bmi))
            return null;

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
        if (is_null($bodyFat))
            return null;

        if ($gender === 'female') {
            if ($bodyFat < 14)
                return 1; // Low
            if ($bodyFat < 32)
                return 2; // Normal
            return 3; // High
        } elseif ($gender === 'male') {
            if ($bodyFat < 6)
                return 1; // Low
            if ($bodyFat < 25)
                return 2; // Normal
            return 3; // High
        }

        return null;
    }
}
