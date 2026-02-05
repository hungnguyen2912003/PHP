<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\User\Weight\StoreWeightRequest;
use App\Http\Requests\Api\User\Weight\UpdateWeightRequest;
use App\Models\Weight;
use App\Http\Resources\Api\User\Weight\WeightResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WeightController extends BaseApiController
{
    public function __construct()
    {
        $this->authorizeResource(Weight::class, 'weight');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $weights = $user->isAdmin() ? Weight::all() : Weight::where('user_id', $user->id)->get();
        return $this->success(WeightResource::collection($weights), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWeightRequest $request)
    {
        $weight = Weight::create($request->validated());
        return $this->success(new WeightResource($weight), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Weight $weight)
    {
        return $this->success(new WeightResource($weight), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWeightRequest $request, Weight $weight)
    {
        $weight->update($request->validated());
        return $this->success(new WeightResource($weight), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Weight $weight)
    {
        $weight->delete();
        return $this->success(null, 200);
    }

    public function chart(Request $request)
    {
        $user = Auth::user();
        $range = $request->query('range', 'days');

        $query = Weight::query();

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        switch ($range) {

            /*
            |======================
            | DAYS
            |======================
            */
            case 'days':
                $data = $query
                    ->select(
                        DB::raw('DATE(recorded_at) as label'),
                        DB::raw('AVG(weight) as value')
                    )
                    ->groupBy(DB::raw('DATE(recorded_at)'))
                    ->orderBy('label', 'desc')   
                    ->limit(7)                   
                    ->get()
                    ->sortBy('label')           
                    ->values()
                    ->map(fn ($item) => [
                        'label' => Carbon::parse($item->label)->format('d M'),
                        'value' => round($item->value, 1),
                    ]);
                break;


            /*
            |======================
            | WEEKS
            |======================
            */
            case 'weeks':
                $startDate = now()->subWeeks(7);

                $data = $query
                    ->whereDate('recorded_at', '>=', $startDate)
                    ->selectRaw('YEARWEEK(recorded_at, 1) as yearweek,
                     MIN(DATE(recorded_at)) as start_date,
                     MAX(DATE(recorded_at)) as end_date,
                     AVG(weight) as value')
                    ->groupBy('yearweek')
                    ->orderBy('yearweek')
                    ->limit(8)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'label' => Carbon::parse($item->start_date)->format('d M') .
                                    ' - ' .
                                    Carbon::parse($item->end_date)->format('d M'),
                            'value' => round($item->value, 1),
                        ];
                    });

                break;


            /*
            |======================
            | MONTHS
            |======================
            */
            case 'months':
                $startDate = now()->subMonths(5);

                // subquery: avg theo ngày
                $daily = $query
                    ->whereDate('recorded_at', '>=', $startDate)
                    ->selectRaw('DATE(recorded_at) as day, AVG(weight) as day_avg')
                    ->groupBy('day');

                // outer query: avg các day_avg theo tháng
                $data = DB::query()
                    ->fromSub($daily, 'd')
                    ->selectRaw('DATE_FORMAT(d.day, "%Y-%m") as month, AVG(d.day_avg) as value')
                    ->groupBy('month')
                    ->orderBy('month')
                    ->limit(6)
                    ->get()
                    ->map(fn ($item) => [
                        'label' => Carbon::createFromFormat('Y-m', $item->month)->format('M Y'),
                        'value' => round($item->value, 2),
                    ]);

                break;

            default:
                return response()->json([
                    'message' => 'Invalid range. Use days, weeks, or months.'
                ], 422);
        }

        return response()->json($data);
    }
}
