<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProtectNonIndexableEnvironment
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! config('website.indexable')) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive');
        }

        return $response;
    }
}
