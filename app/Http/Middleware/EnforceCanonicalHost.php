<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceCanonicalHost
{
    public function handle(Request $request, Closure $next): Response
    {
        $canonicalHost = parse_url((string) config('website.url'), PHP_URL_HOST);
        $requestHost = $request->getHost();

        if (
            config('website.indexable')
            && is_string($canonicalHost)
            && str_starts_with($requestHost, 'www.')
            && substr($requestHost, 4) === $canonicalHost
        ) {
            return redirect()->away(
                'https://'.$canonicalHost.$request->getRequestUri(),
                Response::HTTP_MOVED_PERMANENTLY,
            );
        }

        return $next($request);
    }
}
