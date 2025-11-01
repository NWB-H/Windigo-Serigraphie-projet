<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Non authentifié'], 401);
        }

        if ($request->user()->role !== 'ROLE_ADMIN') {
            return response()->json(['message' => 'Accès interdit'], 403);
        }

        // ✅ Important : passer la requête au suivant
        return $next($request);
    }
}
