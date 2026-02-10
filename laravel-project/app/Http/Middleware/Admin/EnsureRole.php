<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth('admin')->user();

        if (!$user) {
            return redirect()->route('admin.login');
        }

        $requiredRoles = array_map('strtolower', $roles);
        $userRole = strtolower($user->role);

        if (!in_array($userRole, $requiredRoles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
