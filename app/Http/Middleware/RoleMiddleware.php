<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get current user
        $user = Auth::user();

        // Check if user has the required role
        if ($user->role !== $role) {
            abort(403, 'Access denied');
        }

        return $next($request);
    }
}