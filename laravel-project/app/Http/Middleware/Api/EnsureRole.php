<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth('api')->user();

        if (! $user || ! $user->role) {
            return response()->json([
                'status' => 403,
                'message' => 'Forbidden',
                'data' => null
            ], 403);
        }

        $requiredRoles = array_map('strtolower', $roles);
        $userRole = strtolower($user->role);

        if (! in_array($userRole, $requiredRoles, true)) {
            return response()->json([
                'status' => 403,
                'message' => 'Forbidden',
                'data' => null
            ], 403);
        }

        return $next($request);
    }
}
