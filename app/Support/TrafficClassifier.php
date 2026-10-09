<?php

namespace App\Support;

use Illuminate\Http\Request;

class TrafficClassifier
{
    public static function from(Request $request): array
    {
        $userAgent = mb_substr((string) $request->userAgent(), 0, 1000);
        $ua = mb_strtolower($userAgent);
        [$isBot, $botName] = self::bot($ua);
        [$browser, $platform, $device] = self::client($ua);
        $referrer = trim((string) $request->headers->get('referer'));
        $referrerHost = $referrer !== '' ? mb_strtolower((string) parse_url($referrer, PHP_URL_HOST)) : null;
        [$engine, $query] = self::search($referrer, $referrerHost);

        $utmSource = trim((string) $request->query('utm_source'));
        $utmMedium = trim((string) $request->query('utm_medium'));
        $campaign = trim((string) $request->query('utm_campaign'));
        $aiSource = self::aiSource($utmSource, $referrerHost);

        $source = $aiSource ?: ($utmSource ?: ($engine ?: ($referrerHost ?: 'direct')));
        $medium = $utmMedium ?: ($aiSource ? 'ai-referral' : ($engine ? 'organic' : ($referrerHost ? 'referral' : 'direct')));

        $country = collect([
            $request->headers->get('CF-IPCountry'),
            $request->headers->get('CloudFront-Viewer-Country'),
            $request->headers->get('X-Vercel-IP-Country'),
            $request->headers->get('X-Country-Code'),
            $request->headers->get('X-Geo-Country'),
            $request->headers->get('Fastly-Client-Country'),
            $request->server('GEOIP_COUNTRY_CODE'),
            $request->server('HTTP_GEOIP_COUNTRY_CODE'),
            $request->server('MM_COUNTRY_CODE'),
            $request->server('COUNTRY_CODE'),
        ])->first(fn ($value) => is_string($value) && preg_match('/^[A-Za-z]{2}$/', trim($value)));

        return [
            'user_agent' => $userAgent ?: null,
            'is_bot' => $isBot,
            'bot_name' => $botName,
            'browser' => $browser,
            'platform' => $platform,
            'device_type' => $device,
            'referrer_url' => $referrer ?: null,
            'referrer_host' => $referrerHost,
            'search_engine' => $engine,
            'search_query' => $query,
            'source' => mb_substr($source, 0, 100),
            'medium' => mb_substr($medium, 0, 50),
            'campaign' => $campaign !== '' ? mb_substr($campaign, 0, 150) : null,
            'country_code' => $country ? strtoupper(trim($country)) : null,
        ];
    }

    public static function keys(Request $request): array
    {
        $secret = (string) config('app.key');
        $ip = (string) $request->ip();
        $ua = (string) $request->userAgent();
        $sessionId = $request->hasSession() ? (string) $request->session()->getId() : '';

        return [
            'visitor_key' => hash_hmac('sha256', $ip.'|'.$ua, $secret),
            'session_key' => $sessionId !== '' ? hash_hmac('sha256', $sessionId, $secret) : null,
            'ip_hash' => $ip !== '' ? hash_hmac('sha256', $ip, $secret) : null,
        ];
    }

    private static function bot(string $ua): array
    {
        $bots = [
            'googlebot' => 'Googlebot', 'bingbot' => 'Bingbot', 'yandexbot' => 'Yandex',
            'duckduckbot' => 'DuckDuckBot', 'baiduspider' => 'Baidu', 'facebookexternalhit' => 'Facebook',
            'twitterbot' => 'Twitter', 'linkedinbot' => 'LinkedIn', 'applebot' => 'Applebot',
            'gptbot' => 'GPTBot', 'chatgpt-user' => 'ChatGPT', 'oai-searchbot' => 'OpenAI Search',
            'claude-searchbot' => 'Claude Search', 'claude-user' => 'Claude User',
            'claudebot' => 'ClaudeBot', 'claude-web' => 'Claude', 'perplexitybot' => 'Perplexity',
            'bytespider' => 'ByteDance', 'semrushbot' => 'Semrush', 'ahrefsbot' => 'Ahrefs',
            'mj12bot' => 'Majestic', 'crawler' => 'Crawler', 'spider' => 'Spider', 'bot/' => 'Bot',
            'guzzlehttp/' => 'Automated HTTP client', 'curl/' => 'cURL', 'wget/' => 'Wget',
            'python-requests/' => 'Python requests', 'postmanruntime/' => 'Postman', 'okhttp/' => 'OkHttp',
            'axios/' => 'Axios', 'headlesschrome/' => 'Headless Chrome', 'lighthouse' => 'Lighthouse',
            'pagespeed' => 'PageSpeed',
        ];

        foreach ($bots as $needle => $name) {
            if (str_contains($ua, $needle)) {
                return [true, $name];
            }
        }

        return [false, null];
    }

    private static function client(string $ua): array
    {
        $browser = match (true) {
            str_contains($ua, 'edg/') => 'Edge',
            str_contains($ua, 'opr/') || str_contains($ua, 'opera') => 'Opera',
            str_contains($ua, 'firefox/') => 'Firefox',
            str_contains($ua, 'chrome/') || str_contains($ua, 'crios/') => 'Chrome',
            str_contains($ua, 'safari/') => 'Safari',
            default => 'Other',
        };

        $platform = match (true) {
            str_contains($ua, 'android') => 'Android',
            str_contains($ua, 'iphone') || str_contains($ua, 'ipad') => 'iOS',
            str_contains($ua, 'windows') => 'Windows',
            str_contains($ua, 'macintosh') || str_contains($ua, 'mac os') => 'macOS',
            str_contains($ua, 'linux') => 'Linux',
            default => 'Other',
        };

        $device = match (true) {
            str_contains($ua, 'ipad') || str_contains($ua, 'tablet') => 'tablet',
            str_contains($ua, 'mobile') || str_contains($ua, 'iphone') || str_contains($ua, 'android') => 'mobile',
            default => 'desktop',
        };

        return [$browser, $platform, $device];
    }

    private static function aiSource(string $utmSource, ?string $host): ?string
    {
        $candidates = array_filter([$utmSource, $host], fn (?string $value): bool => filled($value));

        foreach (config('website.discovery.ai_referrers', []) as $source => $domains) {
            foreach ($candidates as $candidate) {
                $candidate = mb_strtolower(trim((string) $candidate));
                if (str_contains($candidate, '://')) {
                    $candidate = mb_strtolower((string) (parse_url($candidate, PHP_URL_HOST) ?: $candidate));
                }
                $candidate = trim($candidate, '.');

                foreach ((array) $domains as $domain) {
                    $domain = mb_strtolower(trim((string) $domain, '.'));
                    if ($candidate === $domain || str_ends_with($candidate, '.'.$domain)) {
                        return (string) $source;
                    }
                }
            }
        }

        return null;
    }

    private static function search(string $referrer, ?string $host): array
    {
        if (! $host || $referrer === '') {
            return [null, null];
        }

        $engines = [
            'google.' => ['Google', 'q'],
            'bing.com' => ['Bing', 'q'],
            'search.yahoo.' => ['Yahoo', 'p'],
            'duckduckgo.com' => ['DuckDuckGo', 'q'],
            'yandex.' => ['Yandex', 'text'],
            'baidu.com' => ['Baidu', 'wd'],
        ];

        foreach ($engines as $needle => [$name, $parameter]) {
            if (! str_contains($host, $needle)) {
                continue;
            }

            parse_str((string) parse_url($referrer, PHP_URL_QUERY), $query);
            $term = trim((string) ($query[$parameter] ?? ''));

            return [$name, $term !== '' ? mb_substr($term, 0, 255) : null];
        }

        return [null, null];
    }
}
