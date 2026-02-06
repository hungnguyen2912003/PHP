<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Measurement;
use App\Http\Requests\Api\Measurement\StoreMeasurementRequest;
use App\Http\Requests\Api\Measurement\UpdateMeasurementRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MeasurementController extends BaseApiController
{
    public function __construct()
    {
        $this->authorizeResource(Measurement::class, 'measurement');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Measurement::query();

        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        return $this->success($query->latest('recorded_at')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMeasurementRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        // Combine date and time if available
        if ($request->filled('date') && $request->filled('time')) {
            $data['recorded_at'] = $request->date . ' ' . $request->time . ':00';
        } elseif (!$request->filled('recorded_at')) {
            $data['recorded_at'] = now();
        }

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('measurements', 'public');
            $data['attachment_url'] = Storage::url($path);
        }

        $measurement = Measurement::updateOrCreate(
            [
                'user_id' => $data['user_id'],
                'recorded_at' => $data['recorded_at'],
            ],
            $data
        );

        return $this->success($measurement, 201);
    }

    public function show(Measurement $measurement)
    {
        $user = $measurement->user;
        $weight = (float) $measurement->weight;
        $height = (float) $measurement->height;
        
        $bmiValue = 0.0;
        if ($height > 0) {
            $bmiValue = round($weight / pow($height / 100, 2), 1);
        }

        $bodyFat = null;
        $fatFreeWeight = null;

        if ($user && $user->date_of_birth && $user->gender && $bmiValue > 0) {
            $age = $user->date_of_birth->age;
            
            if ($user->gender === 'male') {
                $bodyFat = (1.20 * $bmiValue) + (0.23 * $age) - 16.2;
            } else {
                $bodyFat = (1.20 * $bmiValue) + (0.23 * $age) - 5.4;
            }

            $bodyFat = max(0, round($bodyFat, 1));
            
            $fatFreeWeight = round($weight * (1 - $bodyFat / 100), 1);
        }

        return $this->success([
            'record' => $measurement,
            'metrics' => [
                'bmi' => [
                    'value' => $bmiValue
                ],
                'body_fat' => [
                    'value' => $bodyFat
                ],
                'fat_free_weight' => [
                    'value' => $fatFreeWeight
                ],
            ]
        ]);
    }

    private function getBmiStatus($bmiValue)
    {
        if ($bmiValue <= 0) return 'Unknown';
        if ($bmiValue < 18.5) return 'Underweight';
        if ($bmiValue < 23) return 'Normal';
        if ($bmiValue < 25) return 'Overweight';
        return 'Obese';
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMeasurementRequest $request, Measurement $measurement)
    {
        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($measurement->attachment_url) {
                $oldPath = str_replace('/storage/', '', $measurement->attachment_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('attachment')->store('measurements', 'public');
            $data['attachment_url'] = Storage::url($path);
        }

        $measurement->update($data);

        return $this->success($measurement);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Measurement $measurement)
    {
        if ($measurement->attachment_url) {
            $path = str_replace('/storage/', '', $measurement->attachment_url);
            Storage::disk('public')->delete($path);
        }

        $measurement->delete();

        return $this->success(null, 204);
    }

    /**
     * Get weight chart data for the authenticated user.
     */
    public function weightChart(Request $request)
    {
        $user = Auth::user();
        $range = $request->query('range', 'days');

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
     * Get a summary of metrics (Weight, Height, BMI) for a specific date.
     */
    public function dailySummary(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'recorded_at' => ['nullable', 'date_format:Y-m-d'],
        ]);

        $date = $request->query('recorded_at', now()->toDateString());

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

}
