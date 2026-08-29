<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = (string) $request->route('locale', config('website.default_locale'));
        $supported = array_keys(config('website.locales', []));

        abort_unless(in_array($locale, $supported, true), 404);

        App::setLocale($locale);
        $request->route()?->forgetParameter('locale');

        return $next($request);
    }
}
