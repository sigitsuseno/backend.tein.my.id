<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user()->load('roles');
        Log::info('RoleMiddleware: user roles', $user->roles->pluck('slug')->toArray());
        Log::info('RoleMiddleware: allowed roles', $roles);

        if ($user->hasRole($roles)) {
            return $next($request);
        }

        abort(403, 'Access Denied - You do not have permission to access this page.');
    }
}
