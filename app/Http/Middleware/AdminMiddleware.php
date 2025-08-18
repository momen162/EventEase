<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // your users table already has a 'role' column:contentReference[oaicite:0]{index=0}
        if (!auth()->check() || strtolower((string)auth()->user()->role) !== 'admin') {
            abort(403, 'Admins only');
        }
        return $next($request);
    }
}
