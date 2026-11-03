<?php

namespace App\Http\Middleware;

use App\Support\WebsiteSettings;
use App\Support\WebsiteTemplate;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\View\FileViewFinder;
use Symfony\Component\HttpFoundation\Response;

class ApplyWebsiteSettings
{
    /**
     * Views in this folder replace the shared public views while the Fida 2026 template is active.
     * Anything not overridden there falls back to resources/views as usual.
     */
    public const MODERN_VIEW_PATH = 'views/templates/modern';

    public function __construct(private WebsiteSettings $settings)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $this->settings->apply();
        $this->selectTemplateViews($request);

        return $next($request);
    }

    private function selectTemplateViews(Request $request): void
    {
        $finder = View::getFinder();

        if (! $finder instanceof FileViewFinder) {
            return;
        }

        $overridePath = resource_path(self::MODERN_VIEW_PATH);
        $paths = array_values(array_filter($finder->getPaths(), fn (string $path) => $path !== $overridePath));

        if (! $request->is('admin', 'admin/*') && WebsiteTemplate::resolve($request) === 'modern' && is_dir($overridePath)) {
            array_unshift($paths, $overridePath);
        }

        $finder->setPaths($paths);
        $finder->flush();
    }
}
