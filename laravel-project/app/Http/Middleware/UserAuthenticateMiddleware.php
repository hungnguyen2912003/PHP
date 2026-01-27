<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class UserAuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            flash()->error('Please login to use this feature');
            return redirect()->route('login');
        }

        $user = Auth::user();
        if ($user->status === 'pending') {
            $allowed = ['profile', 'logout', 'resend-activation'];
            if (!in_array($request->route()->getName(), $allowed)) {
                flash()->warning('Please activate your account to use this feature.');
                return redirect()->route('profile');
            }
        }

        return $next($request);
    }
}
