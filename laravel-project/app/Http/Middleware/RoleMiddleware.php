<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {

        $token = $request->cookie('auth_token');

        if ($token && ! $request->bearerToken()) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        if (! auth('api')->check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status_code' => 401,
                ], 401);
            }

            if ($role === 'admin') {
                return redirect()->route('admin.login');
            }
            return redirect()->route('client.login');
        }

        if (auth('api')->user()->role !== $role) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status_code' => 403,
                ], 403);
            }
            if ($role === 'admin') {
                return redirect()->route('admin.login');
            }
            return redirect()->route('client.login');
        }

        return $next($request);
    }
}
