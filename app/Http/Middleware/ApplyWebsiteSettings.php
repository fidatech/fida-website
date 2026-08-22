<?php

namespace App\Http\Middleware;

use App\Support\WebsiteSettings;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplyWebsiteSettings
{
    public function handle(Request $request, Closure $next, WebsiteSettings $settings): Response
    {
        $settings->apply();

        return $next($request);
    }
}
