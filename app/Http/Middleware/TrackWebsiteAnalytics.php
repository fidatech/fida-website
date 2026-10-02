<?php

namespace App\Http\Middleware;

use App\Models\ContentPage;
use App\Models\WebsitePageView;
use App\Support\TrafficClassifier;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackWebsiteAnalytics
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldTrack($request, $response)) {
            return $response;
        }

        try {
            $traffic = TrafficClassifier::from($request);
            $keys = TrafficClassifier::keys($request);
            $routePage = $request->route('page');
            $slug = $routePage instanceof ContentPage ? $routePage->slug : null;
            $now = now();

            WebsitePageView::create([
                ...$keys,
                ...$traffic,
                'occurred_at' => $now,
                'day' => $now->toDateString(),
                'path' => mb_substr('/'.ltrim($request->path(), '/'), 0, 512),
                'route_name' => $request->route()?->getName(),
                'page_slug' => $slug,
                'locale' => app()->getLocale(),
                'status_code' => $response->getStatusCode(),
            ]);
        } catch (\Throwable $exception) {
            report($exception);
        }

        return $response;
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if (! $request->isMethod('GET') || $request->is('admin/*', 'up', 'robots.txt', 'sitemap.xml', 'sitemaps/*', 'indexnow-key.txt')) {
            return false;
        }

        if ($response->getStatusCode() >= 400) {
            return false;
        }

        $contentType = (string) $response->headers->get('Content-Type');

        return $contentType === '' || str_contains($contentType, 'text/html');
    }
}
