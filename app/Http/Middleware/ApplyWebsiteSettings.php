<?php

namespace App\Http\Middleware;

use App\Support\WebsiteSettings;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplyWebsiteSettings
{
    public function __construct(private WebsiteSettings $settings)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $this->settings->apply();

        return $next($request);
    }
}
