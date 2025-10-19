<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateKeyname
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $keyname = $request->route('keyname');

        $ignore = ['admin', 'login', 'register', 'logout', 'beranda', 'profile', 'product', 'item', 'berita'];
        if (! $keyname) {
            return $next($request);
        }

        if (! User::where('username', $keyname)->orWhere('uuid', $keyname)->exists()) {
            abort(404);
        }

        return $next($request);
    }
}
