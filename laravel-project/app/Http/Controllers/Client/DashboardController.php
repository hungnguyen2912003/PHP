<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Weight;
use App\Models\Height;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    |
    */
    public function index()
    {
        // ... (preserving existing index logic)
        $userId = auth()->id();

        $weights = $this->fetchData('weight', 'days', $userId);
        $heights = $this->fetchData('height', 'days', $userId);

        // Get today's values (specifically for today's date if exists)
        $todayDate = now()->format('Y-m-d');
        $todayWeightData = $weights->firstWhere('date', $todayDate);
        $todayHeightData = $heights->firstWhere('date', $todayDate);

        $avgWeight = $todayWeightData ? round($todayWeightData['value'], 1) : 0;
        $avgHeight = $todayHeightData ? round($todayHeightData['value'], 1) : 0;

        $bmi = 0;
        $bmiPercentage = 0;
        $bmiColor = '#6c757d'; // Default gray

        if ($avgHeight > 0 && $avgWeight > 0) {
            $heightInMeters = $avgHeight / 100;
            $bmi = round($avgWeight / ($heightInMeters * $heightInMeters), 1);

            // Calculate percentage for indicator (4 segments: <18.5, 18.5-25, 25-30, >30)
            if ($bmi < 18.5) {
                // First 25%
                $bmiPercentage = ($bmi / 18.5) * 25;
                $bmiColor = '#4A90E2'; // Underweight blue
            } elseif ($bmi < 25) {
                // Next 25%
                $bmiPercentage = 25 + (($bmi - 18.5) / (25 - 18.5)) * 25;
                $bmiColor = '#27AE60'; // Normal green
            } elseif ($bmi < 30) {
                // Next 25%
                $bmiPercentage = 50 + (($bmi - 25) / (30 - 25)) * 25;
                $bmiColor = '#F39C12'; // Overweight orange
            } else {
                // Last 25% (cap at 40 for 100%)
                $bmiPercentage = 75 + (($bmi - 30) / (40 - 30)) * 25;
                $bmiColor = '#E74C3C'; // Obese red
            }
            $bmiPercentage = min(max($bmiPercentage, 0), 100);
        }

        return view('client.pages.dashboard.index', compact(
            'weights',
            'heights',
            'avgWeight',
            'avgHeight',
            'bmi',
            'bmiPercentage',
            'bmiColor',
        ));
    }

    /**
     * AJAX endpoint for chart data
     */
    public function getChartData(Request $request)
    {
        $type = $request->get('type', 'weight'); // weight or height
        $filter = $request->get('filter', 'days'); // days, weeks, months
        $userId = auth()->id();

        $data = $this->fetchData($type, $filter, $userId);

        return response()->json($data);
    }

    /**
     * Helper to fetch and aggregate data
     */
    private function fetchData($type, $filter, $userId)
    {
        $model = ($type === 'weight') ? new Weight() : new Height();
        $column = $type; // weight column or height column

        $query = $model::where('user_id', $userId)->orderBy('recorded_at', 'desc');

        if ($filter === 'weeks') {
            // Group by Week (Year-Week)
            return $query->get()
                ->groupBy(function ($item) {
                    return $item->recorded_at->format('Y-W');
                })
                ->take(8) // Last 8 weeks
                ->map(function ($records) {
                    return [
                        'date' => 'W' . $records->first()->recorded_at->format('W, Y'),
                        'value' => round($records->avg($records->first()->getTable() === 'weights' ? 'weight' : 'height'), 2),
                    ];
                })
                ->values()
                ->reverse()
                ->values();
        } elseif ($filter === 'months') {
            // Group by Month (Year-Month)
            return $query->get()
                ->groupBy(function ($item) {
                    return $item->recorded_at->format('Y-m');
                })
                ->take(6) // Last 6 months
                ->map(function ($records) {
                    return [
                        'date' => $records->first()->recorded_at->locale(app()->getLocale())->translatedFormat('M Y'),
                        'value' => round($records->avg($records->first()->getTable() === 'weights' ? 'weight' : 'height'), 2),
                    ];
                })
                ->values()
                ->reverse()
                ->values();
        } else {
            // Default: Days (Last 7 days with records)
            return $query->get()
                ->groupBy(function ($item) {
                    return $item->recorded_at->format('Y-m-d');
                })
                ->take(7)
                ->map(function ($dayRecords) use ($type) {
                    return [
                        'date' => $dayRecords->first()->recorded_at->format('Y-m-d'),
                        'value' => round($dayRecords->avg($type), 2),
                    ];
                })
                ->values()
                ->reverse()
                ->values();
        }
    }
}
