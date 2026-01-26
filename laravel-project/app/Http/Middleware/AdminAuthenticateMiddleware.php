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
            flash()->error('Please login to go to admin page');
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role->name !== 'Admin') {
            flash()->error('You do not have permission to access the admin page');
            return redirect()->route('home');
        }

        if ($user->status !== 'active') {
            flash()->error('Your account is not active or has been restricted');
            return redirect()->route('home');
        }

        return $next($request);
    }
}
