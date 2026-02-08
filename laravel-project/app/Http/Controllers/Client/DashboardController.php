<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    |
    */
    public function index(Request $request, \App\DataTables\MeasurementDataTable $dataTable)
    {
        $user = Auth::guard('web')->user();
        $filter = $request->query('filter', 'day');

        $labels = [];
        $fullLabels = [];
        $weightData = [];
        $heightData = [];
        $fromDates = [];
        $toDates = [];

        if ($filter === 'day') {
            // Last 7 calendar days ending today
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $labels[] = $date->format('d/m');
                $fullLabels[] = \Illuminate\Support\Str::ucfirst($date->translatedFormat(__('label.dashboard_date_format')));
                $fromDates[] = $date->toDateString();
                $toDates[] = $date->toDateString();

                $dayData = \App\Models\Measurement::where('user_id', $user->id)
                    ->whereDate('recorded_at', $date->toDateString())
                    ->get();

                $weightData[] = $dayData->count() > 0 ? round((float) $dayData->avg('weight'), 2) : 0;
                $heightData[] = $dayData->count() > 0 ? round((float) $dayData->avg('height'), 2) : 0;
            }
        } elseif ($filter === 'week') {
            // Last 7 calendar weeks ending this week
            for ($i = 6; $i >= 0; $i--) {
                $start = now()->subWeeks($i)->startOfWeek();
                $end = now()->subWeeks($i)->endOfWeek();

                $labels[] = $start->format('d/m') . '-' . $end->format('d/m');
                $fullLabels[] = __('label.from') . ' ' . $start->format('d/m') . ' ' . __('label.to') . ' ' . $end->format('d/m');
                $fromDates[] = $start->toDateString();
                $toDates[] = $end->toDateString();

                $weekData = \App\Models\Measurement::where('user_id', $user->id)
                    ->whereBetween('recorded_at', [$start, $end])
                    ->get();

                $weightData[] = $weekData->count() > 0 ? round((float) $weekData->avg('weight'), 2) : 0;
                $heightData[] = $weekData->count() > 0 ? round((float) $weekData->avg('height'), 2) : 0;
            }
        } else {
            // Last 7 calendar months ending this month
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $start = $date->copy()->startOfMonth();
                $end = $date->copy()->endOfMonth();

                $labels[] = $date->format('M Y');
                $fullLabels[] = __('label.month') . ' ' . $date->format('m/Y');
                $fromDates[] = $start->toDateString();
                $toDates[] = $end->toDateString();

                $monthData = \App\Models\Measurement::where('user_id', $user->id)
                    ->whereMonth('recorded_at', $date->month)
                    ->whereYear('recorded_at', $date->year)
                    ->get();

                $weightData[] = $monthData->count() > 0 ? round((float) $monthData->avg('weight'), 2) : 0;
                $heightData[] = $monthData->count() > 0 ? round((float) $monthData->avg('height'), 2) : 0;
            }
        }

        $chartData = [
            'labels' => $labels,
            'full_labels' => $fullLabels,
            'from_dates' => $fromDates,
            'to_dates' => $toDates,
            'weight' => $weightData,
            'height' => $heightData,
            'filter' => $filter
        ];

        return $dataTable->render('client.pages.dashboard.index', compact('user', 'chartData'));
    }

}
