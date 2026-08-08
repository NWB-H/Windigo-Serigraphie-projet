<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FeatureEnable
{
    public function handle(Request $request, Closure $next): Response
    {
        abort(Response::HTTP_NOT_FOUND);
    }
}
