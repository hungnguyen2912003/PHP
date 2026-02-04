<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
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

        // Fetch statistics for "User" role
        $userRoleId = Role::where('name', 'User')->first()?->id;

        $stats = [
            'total_users' => User::where('role_id', $userRoleId)->count(),
            'new_users_month' => User::where('role_id', $userRoleId)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'pending_users' => User::where('role_id', $userRoleId)
                ->where('status', 'pending')
                ->count(),
            'banned_users' => User::where('role_id', $userRoleId)
                ->where('status', 'banned')
                ->count(),
        ];

        // Fetch trend data (last 10 days)
        $days = 10;
        $trendDates = collect(range($days - 1, 0))->map(fn($i) => now()->subDays($i)->format('Y-m-d'));
        
        $registrations = User::where('role_id', $userRoleId)
            ->where('created_at', '>=', now()->subDays($days))
            ->get()
            ->groupBy(fn($u) => $u->created_at->format('Y-m-d'));

        $totalUsersBefore = User::where('role_id', $userRoleId)
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
            $trends['pending_users'][] = $dayUsers->where('status', 'pending')->count();
            $trends['banned_users'][] = $dayUsers->where('status', 'banned')->count();
        }

        return view('admin.pages.dashboard.index', compact('user', 'stats', 'trends'));
    }
}
