<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Throwable;

class AuditWebsiteDeployment extends Command
{
    protected $signature = 'website:deployment-audit
        {base-url : Absolute staging or production website URL}
        {--mode=staging : Expected deployment mode: staging or production}';

    protected $description = 'Crawl a deployed website and verify indexing, sitemap, canonical, hreflang and security behavior';

    private array $failures = [];

    private array $responses = [];

    private int $checks = 0;

    public function handle(): int
    {
        $baseUrl = rtrim((string) $this->argument('base-url'), '/');
        $mode = strtolower((string) $this->option('mode'));

        if (! filter_var($baseUrl, FILTER_VALIDATE_URL) || ! in_array(parse_url($baseUrl, PHP_URL_SCHEME), ['http', 'https'], true)) {
            $this->error('The base URL must be an absolute HTTP or HTTPS URL.');

            return self::FAILURE;
        }

        if (! in_array($mode, ['staging', 'production'], true)) {
            $this->error('The mode must be staging or production.');

            return self::FAILURE;
        }

        $mode === 'staging'
            ? $this->auditStaging($baseUrl)
            : $this->auditProduction($baseUrl);

        if ($this->failures !== []) {
            $this->table(
                ['URL', 'Check', 'Observed'],
                array_map(fn (array $failure): array => [
                    $failure['url'],
                    $failure['check'],
                    $failure['observed'],
                ], $this->failures),
            );
        }

        $this->line(sprintf(
            'Deployment audit: %s mode, %d URLs requested, %d checks, %d failures.',
            $mode,
            count($this->responses),
            $this->checks,
            count($this->failures),
        ));

        if ($this->failures !== []) {
            $this->error('Deployment audit failed. Do not enable indexing or submit URLs.');

            return self::FAILURE;
        }

        $this->info('Deployment audit passed.');

        return self::SUCCESS;
    }

    private function auditStaging(string $baseUrl): void
    {
        foreach (['/', '/fa', '/ps', '/erp-systems-afghanistan', '/fa/erp-systems-afghanistan', '/ps/erp-systems-afghanistan'] as $path) {
            $url = $baseUrl.$path;
            $response = $this->request($url);

            if (! $response) {
                continue;
            }

            $this->check($response->status() === 200, $url, 'HTTP 200', (string) $response->status());
            $this->check(
                str_contains(strtolower($response->header('X-Robots-Tag')), 'noindex'),
                $url,
                'X-Robots-Tag contains noindex',
                $response->header('X-Robots-Tag') ?: 'missing',
            );
            $this->check(
                preg_match('/<meta\s+name=["\']robots["\']\s+content=["\'][^"\']*noindex/i', $response->body()) === 1,
                $url,
                'HTML robots meta contains noindex',
                'not found',
            );
            $this->auditCommonSecurityHeaders($url, $response);
        }

        $robotsUrl = $baseUrl.'/robots.txt';
        $robots = $this->request($robotsUrl);

        if ($robots) {
            $this->check($robots->status() === 200, $robotsUrl, 'HTTP 200', (string) $robots->status());
            $this->check(str_contains($robots->body(), 'Disallow: /'), $robotsUrl, 'robots.txt blocks crawling', trim($robots->body()));
            $this->check(! str_contains($robots->body(), 'Sitemap:'), $robotsUrl, 'robots.txt omits sitemap', trim($robots->body()));
        }

        $sitemapUrl = $baseUrl.'/sitemap.xml';
        $sitemap = $this->request($sitemapUrl);

        if ($sitemap) {
            $this->check($sitemap->status() === 404, $sitemapUrl, 'Sitemap is unavailable on staging', (string) $sitemap->status());
            $this->check(
                str_contains(strtolower($sitemap->header('X-Robots-Tag')), 'noindex'),
                $sitemapUrl,
                'Sitemap response carries noindex header',
                $sitemap->header('X-Robots-Tag') ?: 'missing',
            );
        }
    }

    private function auditProduction(string $baseUrl): void
    {
        $this->check(parse_url($baseUrl, PHP_URL_SCHEME) === 'https', $baseUrl, 'Production uses HTTPS', (string) parse_url($baseUrl, PHP_URL_SCHEME));

        foreach (['/en', '/en/erp-systems-afghanistan?utm_source=launch-audit'] as $path) {
            $url = $baseUrl.$path;
            $response = $this->request($url);

            if (! $response) {
                continue;
            }

            $expectedPath = substr($path, 3);
            $expectedPath = $expectedPath === '' ? '/' : $expectedPath;
            $expected = $baseUrl.$expectedPath;
            $this->check($response->status() === 301, $url, 'Default-locale URL redirects permanently', (string) $response->status());
            $this->check($response->header('Location') === $expected, $url, 'Default-locale redirect is direct and preserves query', $response->header('Location') ?: 'missing');
        }

        $host = (string) parse_url($baseUrl, PHP_URL_HOST);

        if (! str_starts_with($host, 'www.')) {
            $wwwUrl = 'https://www.'.$host.'/erp-systems-afghanistan?utm_source=launch-audit';
            $www = $this->request($wwwUrl);

            if ($www) {
                $expected = $baseUrl.'/erp-systems-afghanistan?utm_source=launch-audit';
                $this->check($www->status() === 301, $wwwUrl, 'WWW host redirects permanently', (string) $www->status());
                $this->check($www->header('Location') === $expected, $wwwUrl, 'WWW redirect preserves path and query', $www->header('Location') ?: 'missing');
            }
        }

        $robotsUrl = $baseUrl.'/robots.txt';
        $robots = $this->request($robotsUrl);

        if ($robots) {
            $this->check($robots->status() === 200, $robotsUrl, 'HTTP 200', (string) $robots->status());
            $this->check(str_contains($robots->body(), 'Allow: /'), $robotsUrl, 'robots.txt permits crawling', trim($robots->body()));
            $this->check(str_contains($robots->body(), 'Sitemap: '.$baseUrl.'/sitemap.xml'), $robotsUrl, 'robots.txt names canonical sitemap', trim($robots->body()));
            $this->auditCommonSecurityHeaders($robotsUrl, $robots);
        }

        $sitemapUrl = $baseUrl.'/sitemap.xml';
        $sitemap = $this->request($sitemapUrl);

        if (! $sitemap) {
            return;
        }

        $this->check($sitemap->status() === 200, $sitemapUrl, 'Sitemap index returns HTTP 200', (string) $sitemap->status());
        $this->check($this->isXml($sitemap), $sitemapUrl, 'Sitemap index is XML', $sitemap->header('Content-Type') ?: 'missing');
        $sitemapUrls = $this->extractTagValues($sitemap->body(), 'loc');
        $this->check($sitemapUrls !== [], $sitemapUrl, 'Sitemap index contains segment URLs', 'none');
        $publicUrls = [];

        foreach ($sitemapUrls as $groupUrl) {
            $this->check($this->sameOrigin($baseUrl, $groupUrl), $groupUrl, 'Sitemap segment stays on canonical origin', $groupUrl);
            $group = $this->request($groupUrl);

            if (! $group) {
                continue;
            }

            $this->check($group->status() === 200, $groupUrl, 'Sitemap segment returns HTTP 200', (string) $group->status());
            $this->check($this->isXml($group), $groupUrl, 'Sitemap segment is XML', $group->header('Content-Type') ?: 'missing');
            $groupUrls = array_values(array_unique(array_merge(
                $this->extractTagValues($group->body(), 'loc'),
                $this->extractAlternateUrls($group->body()),
            )));
            $this->check($groupUrls !== [], $groupUrl, 'Sitemap segment contains public URLs', 'none');
            $publicUrls = array_merge($publicUrls, $groupUrls);
        }

        $publicUrls = array_values(array_unique($publicUrls));
        $this->check($publicUrls !== [], $sitemapUrl, 'Public sitemap inventory is not empty', 'none');

        foreach ($publicUrls as $url) {
            $this->check($this->sameOrigin($baseUrl, $url), $url, 'Public URL stays on canonical origin', $url);
            $response = $this->request($url);

            if (! $response) {
                continue;
            }

            $this->check($response->status() === 200, $url, 'Public URL returns HTTP 200 without redirect', (string) $response->status());
            $this->check(! str_contains(strtolower($response->header('X-Robots-Tag')), 'noindex'), $url, 'Public URL has no noindex response header', $response->header('X-Robots-Tag') ?: 'none');
            $this->check(
                preg_match('/<meta\s+name=["\']robots["\']\s+content=["\'][^"\']*noindex/i', $response->body()) !== 1,
                $url,
                'Public URL has no noindex robots meta',
                'noindex found',
            );
            $canonical = $this->canonicalFrom($response->body());
            $this->check($canonical === $url, $url, 'Canonical URL is self-referencing', $canonical ?: 'missing');

            foreach (['en', 'fa-AF', 'ps-AF', 'x-default'] as $hreflang) {
                $this->check(
                    preg_match('/<link\s+rel=["\']alternate["\']\s+hreflang=["\']'.preg_quote($hreflang, '/').'["\']\s+href=["\'][^"\']+["\']/i', $response->body()) === 1,
                    $url,
                    "Hreflang {$hreflang} is present",
                    'missing',
                );
            }

            $this->auditCommonSecurityHeaders($url, $response, strictTransport: true);
        }
    }

    private function request(string $url): ?Response
    {
        if (array_key_exists($url, $this->responses)) {
            return $this->responses[$url];
        }

        try {
            return $this->responses[$url] = Http::accept('*/*')
                ->timeout(20)
                ->withOptions(['allow_redirects' => false])
                ->get($url);
        } catch (Throwable $exception) {
            $this->fail($url, 'Request completes successfully', $exception->getMessage());
            $this->responses[$url] = null;

            return null;
        }
    }

    private function auditCommonSecurityHeaders(string $url, Response $response, bool $strictTransport = false): void
    {
        $expected = [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
        ];

        foreach ($expected as $header => $value) {
            $this->check($response->header($header) === $value, $url, "{$header} header is configured", $response->header($header) ?: 'missing');
        }

        if ($strictTransport) {
            $this->check(
                str_contains($response->header('Strict-Transport-Security'), 'max-age='),
                $url,
                'Strict-Transport-Security is configured',
                $response->header('Strict-Transport-Security') ?: 'missing',
            );
        }
    }

    private function check(bool $passed, string $url, string $check, string $observed): void
    {
        $this->checks++;

        if (! $passed) {
            $this->failures[] = compact('url', 'check', 'observed');
        }
    }

    private function fail(string $url, string $check, string $observed): void
    {
        $this->checks++;
        $this->failures[] = compact('url', 'check', 'observed');
    }

    private function isXml(Response $response): bool
    {
        return str_contains(strtolower($response->header('Content-Type')), 'xml');
    }

    private function extractTagValues(string $xml, string $tag): array
    {
        preg_match_all('/<'.preg_quote($tag, '/').'>\s*([^<]+)\s*<\/'.preg_quote($tag, '/').'>/i', $xml, $matches);

        return array_values(array_unique(array_map(
            fn (string $url): string => html_entity_decode(trim($url), ENT_QUOTES | ENT_XML1),
            $matches[1] ?? [],
        )));
    }

    private function extractAlternateUrls(string $xml): array
    {
        preg_match_all('/<xhtml:link\s+[^>]*href=["\']([^"\']+)["\'][^>]*\/?>/i', $xml, $matches);

        return array_values(array_unique(array_map(
            fn (string $url): string => html_entity_decode(trim($url), ENT_QUOTES | ENT_XML1),
            $matches[1] ?? [],
        )));
    }

    private function canonicalFrom(string $html): ?string
    {
        if (preg_match('/<link\s+rel=["\']canonical["\']\s+href=["\']([^"\']+)["\']/i', $html, $match) !== 1) {
            return null;
        }

        return html_entity_decode(trim($match[1]), ENT_QUOTES | ENT_HTML5);
    }

    private function sameOrigin(string $baseUrl, string $url): bool
    {
        return parse_url($baseUrl, PHP_URL_SCHEME) === parse_url($url, PHP_URL_SCHEME)
            && parse_url($baseUrl, PHP_URL_HOST) === parse_url($url, PHP_URL_HOST)
            && (parse_url($baseUrl, PHP_URL_PORT) ?: null) === (parse_url($url, PHP_URL_PORT) ?: null);
    }
}
