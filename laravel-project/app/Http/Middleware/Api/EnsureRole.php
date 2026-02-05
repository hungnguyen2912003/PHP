<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth('api')->user();

        if (! $user || ! $user->role || ! in_array($user->role->name, $roles)) {
            return response()->json([
                'status_code' => 403,
                'body' => [
                    'data' => null
                ]
            ], 403);
        }

        return $next($request);
    }
}
