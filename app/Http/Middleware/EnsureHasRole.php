<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $roleEnum = RoleEnum::tryFrom($role);

        if (!$request->user() || $request->user()->role !== $roleEnum) {
            abort(403);
        }

        return $next($request);
    }
}
