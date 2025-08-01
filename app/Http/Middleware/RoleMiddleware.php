<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        if (!$user) {
            // Untuk API
            return $request->expectsJson()
                ? response()->json(['message' => 'Unauthenticated'], 403)
                : abort(403, 'Anda belum login.');
        }

        if (!in_array($user->role, $roles)) {
            // Untuk API
            return $request->expectsJson()
                ? response()->json(['message' => 'Unauthorized - Role not allowed'], 403)
                : abort(403, 'Akses ditolak untuk role ini.');
        }

        return $next($request);
    }
}
