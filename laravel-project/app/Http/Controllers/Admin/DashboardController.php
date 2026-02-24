<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'new_users_month' => User::where('role', 'user')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'pending_users' => User::where('role', 'user')
                ->where('status', User::STATUS_PENDING)
                ->count(),
            'banned_users' => User::where('role', 'user')
                ->where('status', User::STATUS_BANNED)
                ->count(),
        ];

        // Fetch trend data (last 10 days)
        $days = 10;
        $trendDates = collect(range($days - 1, 0))->map(fn($i) => now()->subDays($i)->format('Y-m-d'));

        $registrations = User::where('role', 'user')
            ->where('created_at', '>=', now()->subDays($days))
            ->get()
            ->groupBy(fn($u) => $u->created_at->format('Y-m-d'));

        $totalUsersBefore = User::where('role', 'user')
            ->where('created_at', '<', now()->subDays($days))
            ->count();

        $trends = [
            'total_users' => [],
            'new_users' => [],
            'pending_users' => [],
            'banned_users' => [],
        ];

        $runningTotal = $totalUsersBefore;
        foreach ($trendDates as $date) {
            $dayUsers = isset($registrations[$date]) ? $registrations[$date] : collect();
            $count = $dayUsers->count();
            $runningTotal += $count;

            $trends['total_users'][] = $runningTotal;
            $trends['new_users'][] = $count;
            $trends['pending_users'][] = $dayUsers->where('status', User::STATUS_PENDING)->count();
            $trends['banned_users'][] = $dayUsers->where('status', User::STATUS_BANNED)->count();
        }

        return view('admin.pages.dashboard.index', compact('user', 'stats', 'trends'));
    }
}
