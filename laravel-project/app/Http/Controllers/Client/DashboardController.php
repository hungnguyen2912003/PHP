<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Weight;
use App\Models\Height;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $userId = auth()->id();

        $weights = Weight::where('user_id', $userId)
            ->orderBy('recorded_at', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return $item->recorded_at->format('Y-m-d');
            })
            ->take(7)
            ->map(function ($dayRecords) {
                return [
                    'date' => $dayRecords->first()->recorded_at->format('Y-m-d'),
                    'value' => round($dayRecords->avg('weight'), 2),
                ];
            })
            ->values()
            ->reverse()
            ->values();

        $heights = Height::where('user_id', $userId)
            ->orderBy('recorded_at', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return $item->recorded_at->format('Y-m-d');
            })
            ->take(7)
            ->map(function ($dayRecords) {
                return [
                    'date' => $dayRecords->first()->recorded_at->format('Y-m-d'),
                    'value' => round($dayRecords->avg('height'), 2),
                ];
            })
            ->values()
            ->reverse()
            ->values();

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
}
