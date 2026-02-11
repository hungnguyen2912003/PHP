<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Measurement;
use App\Http\Requests\Api\Measurement\StoreWeightRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\HealthStatusService;

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

        $limit = $request->input('limit', 7);
        $offset = $request->input('offset', 0);
        $from = $request->input('from');
        $to = $request->input('to');

        if ($from && $to) {
            $start = Carbon::parse($from)->startOf($unit);
            $end = Carbon::parse($to)->endOf($unit);
        } else {
            $end = now()->sub($unit, $offset * $limit)->endOf($unit);
            $start = $end->copy()->sub($unit, $limit - 1)->startOf($unit);
        }

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
                        'bmi' => round((float) $items->avg('weight') / pow($height / 100, 2), 1),
                        'bmi_status' => HealthStatusService::bmi((float) $items->avg('weight') / pow($height / 100, 2)),
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
     * Store a weight record.
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

        $gender = $measurement->user->gender ?? null;

        $metrics = [
            'weight' => [
                'value' => (float) $measurement->weight,
                'status' => HealthStatusService::bmi($measurement->bmi),
            ],
            'height' => [
                'value' => (float) $measurement->height,
                'status' => HealthStatusService::height($measurement->height),
            ],
            'bmi' => [
                'value' => (float) $measurement->bmi,
                'status' => HealthStatusService::bmi($measurement->bmi),
            ],
            'body_fat' => [
                'value' => (float) $measurement->body_fat,
                'status' => HealthStatusService::bodyFat($measurement->body_fat, $gender),
            ],
            'fat_free_body_weight' => [
                'value' => (float) $measurement->fat_free_body_weight,
                'status' => null,
            ],
            'muscle_mass' => [
                'value' => (float) $measurement->muscle_mass,
                'status' => HealthStatusService::muscleMass($measurement->muscle_mass, $measurement->weight),
            ],
            'skeletal_muscle_mass' => [
                'value' => (float) $measurement->skeletal_muscle_mass,
                'status' => HealthStatusService::skeletalMuscle($measurement->skeletal_muscle_mass),
            ],
            'subcutaneous_fat' => [
                'value' => (float) $measurement->subcutaneous_fat,
                'status' => HealthStatusService::subcutaneousFat($measurement->subcutaneous_fat),
            ],
            'visceral_fat' => [
                'value' => (float) $measurement->visceral_fat,
                'status' => HealthStatusService::visceralFat($measurement->visceral_fat),
            ],
            'body_water' => [
                'value' => (float) $measurement->body_water,
                'status' => HealthStatusService::bodyWater($measurement->body_water),
            ],
            'protein' => [
                'value' => (float) $measurement->protein,
                'status' => HealthStatusService::protein($measurement->protein),
            ],
            'bone_mass' => [
                'value' => (float) $measurement->bone_mass,
                'status' => HealthStatusService::boneMass($measurement->bone_mass, $measurement->weight),
            ],
            'bmr' => [
                'value' => (float) $measurement->bmr,
                'status' => HealthStatusService::bmr($measurement->bmr, $gender),
            ],
            'whr' => [
                'value' => (float) $measurement->whr,
                'status' => HealthStatusService::whr($measurement->whr, $gender),
            ],
        ];

        return $this->success([
            'id' => $measurement->id,
            'recorded_at' => $measurement->recorded_at->timestamp,
            'metrics' => $metrics
        ]);
    }
}
