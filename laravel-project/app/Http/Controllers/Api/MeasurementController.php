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

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('measurements', 'public');
            $data['attachment_url'] = Storage::url($path);
        }

        $measurement = Measurement::create($data);

        return $this->success($measurement, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Measurement $measurement)
    {
        return $this->success($measurement);
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
     * 
     */

    
}
