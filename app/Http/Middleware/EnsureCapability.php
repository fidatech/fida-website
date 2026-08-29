<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCapability
{
    public function handle(Request $request, Closure $next, string $capability): Response
    {
        abort_unless($request->user()?->allows($capability), 403);

        return $next($request);
    }
}
