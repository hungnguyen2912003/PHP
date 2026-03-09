<?php

namespace App\Http\Middleware\Api;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    use \App\Traits\ApiResponse;

    /**
     * Map role names (from routes) to integer constants.
     */
    private const ROLE_MAP = [
        'admin' => User::ROLE_ADMIN,
        'staff' => User::ROLE_STAFF,
        'user'  => User::ROLE_USER,
    ];

    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth('api')->user();

        if (! $user || ! $user->role) {
            return $this->error(403);
        }

        // Convert role names from route to integer values
        $allowedRoles = array_map(function ($role) {
            return self::ROLE_MAP[strtolower($role)] ?? null;
        }, $roles);

        if (! in_array($user->role, $allowedRoles, true)) {
            return $this->error(403);
        }

        return $next($request);
    }
}
