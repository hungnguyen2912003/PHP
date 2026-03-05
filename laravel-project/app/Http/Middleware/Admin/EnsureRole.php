<?php

namespace App\Http\Middleware\Admin;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Map role names (from routes) to integer constants.
     */
    private const ROLE_MAP = [
        'admin' => User::ROLE_ADMIN,
        'staff' => User::ROLE_STAFF,
        'user'  => User::ROLE_USER,
    ];

    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth('admin')->user();

        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Convert role names from route to integer values
        $allowedRoles = array_map(function ($role) {
            return self::ROLE_MAP[strtolower($role)] ?? null;
        }, $roles);

        if (!in_array($user->role, $allowedRoles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
