<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class AdminAuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            flash()->error('messages.login_require');
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role->name !== 'Admin') {
            flash()->error('messages.permission_denied');
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
