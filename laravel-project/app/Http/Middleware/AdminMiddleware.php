<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasCookie('auth_token') && !$request->header('Authorization')) {
            $request->headers->set('Authorization', 'Bearer ' . $request->cookie('auth_token'));
        }



        $user = auth()->user() ?: auth('api')->user();

        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        if ($request->expectsJson() || $request->is('api/*')) {
            abort(403, 'Unauthorized');
        }

        return redirect()->route('admin.login');
    }
}
