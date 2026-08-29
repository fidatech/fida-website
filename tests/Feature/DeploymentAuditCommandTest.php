<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DeploymentAuditCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_staging_deployment_audit_requires_crawler_protection(): void
    {
        Http::fake(function (Request $request) {
            $headers = $this->securityHeaders([
                'X-Robots-Tag' => 'noindex, nofollow, noarchive',
            ]);

            return match ($request->url()) {
                'https://stage.fida.af/robots.txt' => Http::response("User-agent: *\nDisallow: /\n", 200, $headers),
                'https://stage.fida.af/sitemap.xml' => Http::response('Not Found', 404, $headers),
                default => Http::response('<html><head><meta name="robots" content="noindex,nofollow,noarchive"></head></html>', 200, $headers),
            };
        });

        $this->artisan('website:deployment-audit', [
            'base-url' => 'https://stage.fida.af',
            '--mode' => 'staging',
        ])
            ->expectsOutputToContain('Deployment audit: staging mode, 8 URLs requested')
            ->expectsOutput('Deployment audit passed.')
            ->assertSuccessful();
    }

    public function test_production_deployment_audit_crawls_sitemaps_and_canonical_locales(): void
    {
        Http::fake(function (Request $request) {
            $url = $request->url();
            $headers = $this->securityHeaders([
                'Strict-Transport-Security' => 'max-age=31536000',
            ]);

            if (str_starts_with($url, 'https://www.fida.af/')) {
                return Http::response('', 301, ['Location' => str_replace('https://www.fida.af', 'https://fida.af', $url)]);
            }

            if ($url === 'https://fida.af/en') {
                return Http::response('', 301, ['Location' => 'https://fida.af/']);
            }

            if ($url === 'https://fida.af/en/erp-systems-afghanistan?utm_source=launch-audit') {
                return Http::response('', 301, ['Location' => 'https://fida.af/erp-systems-afghanistan?utm_source=launch-audit']);
            }

            if ($url === 'https://fida.af/robots.txt') {
                return Http::response("User-agent: *\nAllow: /\n\nSitemap: https://fida.af/sitemap.xml\n", 200, $headers);
            }

            if ($url === 'https://fida.af/sitemap.xml') {
                return Http::response('<?xml version="1.0"?><sitemapindex><sitemap><loc>https://fida.af/sitemaps/pages.xml</loc></sitemap></sitemapindex>', 200, $headers + ['Content-Type' => 'application/xml']);
            }

            if ($url === 'https://fida.af/sitemaps/pages.xml') {
                return Http::response($this->sitemapFixture(), 200, $headers + ['Content-Type' => 'application/xml']);
            }

            return Http::response($this->pageFixture($url), 200, $headers + ['Content-Type' => 'text/html']);
        });

        $this->artisan('website:deployment-audit', [
            'base-url' => 'https://fida.af',
            '--mode' => 'production',
        ])
            ->expectsOutputToContain('Deployment audit: production mode, 9 URLs requested')
            ->expectsOutput('Deployment audit passed.')
            ->assertSuccessful();
    }

    private function securityHeaders(array $extra = []): array
    {
        return $extra + [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
        ];
    }

    private function sitemapFixture(): string
    {
        return <<<'XML'
<?xml version="1.0"?>
<urlset xmlns:xhtml="http://www.w3.org/1999/xhtml">
    <url>
        <loc>https://fida.af/</loc>
        <xhtml:link rel="alternate" hreflang="en" href="https://fida.af/" />
        <xhtml:link rel="alternate" hreflang="fa-AF" href="https://fida.af/fa" />
        <xhtml:link rel="alternate" hreflang="ps-AF" href="https://fida.af/ps" />
        <xhtml:link rel="alternate" hreflang="x-default" href="https://fida.af/" />
    </url>
</urlset>
XML;
    }

    private function pageFixture(string $canonical): string
    {
        return <<<HTML
<html><head>
<meta name="robots" content="index,follow">
<link rel="canonical" href="{$canonical}">
<link rel="alternate" hreflang="en" href="https://fida.af/">
<link rel="alternate" hreflang="fa-AF" href="https://fida.af/fa">
<link rel="alternate" hreflang="ps-AF" href="https://fida.af/ps">
<link rel="alternate" hreflang="x-default" href="https://fida.af/">
</head><body></body></html>
HTML;
    }
}
