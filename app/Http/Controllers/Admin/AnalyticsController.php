<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsAiInsight;
use App\Models\ContentPage;
use App\Models\SearchConsoleMetric;
use App\Models\WebsiteAnalyticsEvent;
use App\Models\WebsitePageView;
use App\Services\AnalyticsAiAdvisor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class AnalyticsController extends Controller
{
    public function index(Request $request, AnalyticsAiAdvisor $advisor): View
    {
        $days = max(1, min(365, (int) $request->integer('days', 30)));
        $from = now()->startOfDay()->subDays($days - 1);
        $to = now()->endOfDay();

        $humans = WebsitePageView::query()->where('is_bot', false)->whereBetween('occurred_at', [$from, $to]);
        $bots = WebsitePageView::query()->where('is_bot', true)->whereBetween('occurred_at', [$from, $to]);

        $summary = [
            'page_views' => (clone $humans)->count(),
            'visitors' => (clone $humans)->distinct('visitor_key')->count('visitor_key'),
            'sessions' => (clone $humans)->whereNotNull('session_key')->distinct('session_key')->count('session_key'),
            'active_15m' => WebsitePageView::query()
                ->where('is_bot', false)
                ->where('occurred_at', '>=', now()->subMinutes(15))
                ->distinct('visitor_key')
                ->count('visitor_key'),
            'bot_hits' => (clone $bots)->count(),
            'country_known_visitors' => (clone $humans)->whereNotNull('country_code')->distinct('visitor_key')->count('visitor_key'),
            'country_unknown_visitors' => (clone $humans)->whereNull('country_code')->distinct('visitor_key')->count('visitor_key'),
            'conversions' => WebsiteAnalyticsEvent::query()
                ->whereBetween('occurred_at', [$from, $to])
                ->whereIn('event_name', ['lead_submitted', 'rfq_submitted', 'cta_click', 'phone_click', 'email_click', 'whatsapp_click'])
                ->count(),
        ];

        $daily = WebsitePageView::query()
            ->where('is_bot', false)
            ->whereBetween('occurred_at', [$from, $to])
            ->selectRaw('day, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $topPages = WebsitePageView::query()
            ->where('is_bot', false)
            ->whereBetween('occurred_at', [$from, $to])
            ->selectRaw('path, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors')
            ->groupBy('path')
            ->orderByDesc('views')
            ->limit(30)
            ->get();

        $sources = WebsitePageView::query()
            ->where('is_bot', false)
            ->whereBetween('occurred_at', [$from, $to])
            ->selectRaw("COALESCE(NULLIF(source, ''), 'direct') as source_name, COALESCE(NULLIF(medium, ''), 'direct') as medium_name, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors")
            ->groupBy('source_name', 'medium_name')
            ->orderByDesc('views')
            ->limit(30)
            ->get();

        $countries = WebsitePageView::query()
            ->where('is_bot', false)
            ->whereBetween('occurred_at', [$from, $to])
            ->whereNotNull('country_code')
            ->selectRaw("country_code as country, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors")
            ->groupBy('country_code')
            ->orderByDesc('views')
            ->limit(50)
            ->get();

        $devices = WebsitePageView::query()
            ->where('is_bot', false)
            ->whereBetween('occurred_at', [$from, $to])
            ->selectRaw("COALESCE(device_type, 'unknown') as device, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors")
            ->groupBy('device')
            ->orderByDesc('views')
            ->get();

        $botBreakdown = WebsitePageView::query()
            ->where('is_bot', true)
            ->whereBetween('occurred_at', [$from, $to])
            ->selectRaw("COALESCE(bot_name, 'Other bot') as bot, COUNT(*) as hits")
            ->groupBy('bot')
            ->orderByDesc('hits')
            ->limit(100)
            ->get();

        $aiSources = array_keys(config('website.discovery.ai_referrers', []));
        $aiCrawlerNames = (array) config('website.discovery.ai_crawlers', []);
        $aiHumans = WebsitePageView::query()
            ->where('is_bot', false)
            ->whereBetween('occurred_at', [$from, $to])
            ->where(function ($query) use ($aiSources): void {
                $query->whereIn('source', $aiSources)->orWhere('medium', 'ai-referral');
            });
        $aiVisibility = [
            'views' => (clone $aiHumans)->count(),
            'visitors' => (clone $aiHumans)->distinct('visitor_key')->count('visitor_key'),
            'crawler_hits' => (clone $bots)->whereIn('bot_name', $aiCrawlerNames)->count(),
            'providers' => (clone $aiHumans)
                ->selectRaw("COALESCE(NULLIF(source, ''), 'AI referral') as provider, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors")
                ->groupBy('source')
                ->orderByDesc('views')
                ->limit(20)
                ->get(),
            'landing_pages' => (clone $aiHumans)
                ->selectRaw('path, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors')
                ->groupBy('path')
                ->orderByDesc('views')
                ->limit(20)
                ->get(),
        ];

        $events = WebsiteAnalyticsEvent::query()
            ->whereBetween('occurred_at', [$from, $to])
            ->selectRaw('event_name, COUNT(*) as total')
            ->groupBy('event_name')
            ->orderByDesc('total')
            ->get();

        $recentVisitors = WebsitePageView::query()
            ->where('is_bot', false)
            ->whereBetween('occurred_at', [$from, $to])
            ->selectRaw("visitor_key, MAX(occurred_at) as last_seen, COUNT(*) as page_views, MAX(country_code) as country_code, MAX(source) as source_name, MAX(medium) as medium_name, MAX(device_type) as device_type, MAX(browser) as browser")
            ->groupBy('visitor_key')
            ->orderByDesc('last_seen')
            ->limit(40)
            ->get();

        $searchPeriod = SearchConsoleMetric::query()->max('period_end');
        $searchBase = SearchConsoleMetric::query();
        if ($searchPeriod) {
            $searchBase->where('period_end', $searchPeriod);
        }

        $search = [
            'period_end' => $searchPeriod ? Carbon::parse($searchPeriod) : null,
            'queries' => (clone $searchBase)->where('metric_type', 'query')->orderByDesc('impressions')->limit(100)->get(),
            'pages' => (clone $searchBase)->where('metric_type', 'page')->orderByDesc('impressions')->limit(100)->get(),
            'countries' => (clone $searchBase)->where('metric_type', 'country')->orderByDesc('impressions')->limit(100)->get(),
            'devices' => (clone $searchBase)->where('metric_type', 'device')->orderByDesc('impressions')->get(),
        ];

        $search['totals'] = SearchConsoleMetric::query()
            ->when($searchPeriod, fn ($query) => $query->where('period_end', $searchPeriod))
            ->where('metric_type', 'device')
            ->selectRaw('SUM(clicks) as clicks, SUM(impressions) as impressions')
            ->first();

        $search['opportunities'] = SearchConsoleMetric::query()
            ->when($searchPeriod, fn ($query) => $query->where('period_end', $searchPeriod))
            ->where('metric_type', 'page')
            ->where('impressions', '>=', 10)
            ->whereBetween('position', [3, 20])
            ->orderByDesc('impressions')
            ->limit(50)
            ->get();

        $latestInsight = AnalyticsAiInsight::query()->latest()->first();
        $aiConfig = $advisor->configuration();
        $aiConfigured = filled($aiConfig['api_key']);
        unset($aiConfig['api_key']);

        return view('admin.analytics.index', compact(
            'days', 'from', 'to', 'summary', 'daily', 'topPages', 'sources',
            'countries', 'devices', 'botBreakdown', 'aiVisibility', 'events', 'recentVisitors',
            'search', 'latestInsight', 'aiConfig', 'aiConfigured'
        ));
    }

    public function generateAiInsight(Request $request, AnalyticsAiAdvisor $advisor): RedirectResponse
    {
        $days = max(7, min(365, (int) $request->integer('days', 30)));
        $from = now()->startOfDay()->subDays($days - 1);
        $searchPeriod = SearchConsoleMetric::query()->max('period_end');

        $summary = [
            'period_days' => $days,
            'real_traffic' => [
                'page_views' => WebsitePageView::query()->where('is_bot', false)->where('occurred_at', '>=', $from)->count(),
                'visitors' => WebsitePageView::query()->where('is_bot', false)->where('occurred_at', '>=', $from)->distinct('visitor_key')->count('visitor_key'),
                'top_pages' => WebsitePageView::query()->where('is_bot', false)->where('occurred_at', '>=', $from)
                    ->selectRaw('path, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors')
                    ->groupBy('path')->orderByDesc('views')->limit(15)->get()->toArray(),
                'sources' => WebsitePageView::query()->where('is_bot', false)->where('occurred_at', '>=', $from)
                    ->selectRaw("COALESCE(NULLIF(source, ''), 'direct') as source, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors")
                    ->groupBy('source')->orderByDesc('views')->limit(10)->get()->toArray(),
                'countries' => WebsitePageView::query()->where('is_bot', false)->where('occurred_at', '>=', $from)
                    ->selectRaw("COALESCE(country_code, 'unknown') as country, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors")
                    ->groupBy('country')->orderByDesc('views')->limit(10)->get()->toArray(),
                'business_actions' => WebsiteAnalyticsEvent::query()->where('occurred_at', '>=', $from)
                    ->selectRaw('event_name, COUNT(*) as total')->groupBy('event_name')->orderByDesc('total')->get()->toArray(),
            ],
            'ai_visibility' => [
                'referral_views' => WebsitePageView::query()->where('is_bot', false)->where('occurred_at', '>=', $from)
                    ->whereIn('source', array_keys(config('website.discovery.ai_referrers', [])))->count(),
                'referral_visitors' => WebsitePageView::query()->where('is_bot', false)->where('occurred_at', '>=', $from)
                    ->whereIn('source', array_keys(config('website.discovery.ai_referrers', [])))->distinct('visitor_key')->count('visitor_key'),
                'crawler_hits' => WebsitePageView::query()->where('is_bot', true)->where('occurred_at', '>=', $from)
                    ->whereIn('bot_name', (array) config('website.discovery.ai_crawlers', []))->count(),
                'top_sources' => WebsitePageView::query()->where('is_bot', false)->where('occurred_at', '>=', $from)
                    ->whereIn('source', array_keys(config('website.discovery.ai_referrers', [])))
                    ->selectRaw('source, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors')
                    ->groupBy('source')->orderByDesc('views')->limit(10)->get()->toArray(),
            ],
            'google_search_console' => [
                'period_end' => $searchPeriod,
                'top_queries' => SearchConsoleMetric::query()->when($searchPeriod, fn ($q) => $q->where('period_end', $searchPeriod))
                    ->where('metric_type', 'query')->orderByDesc('impressions')->limit(20)->get(['dimension', 'clicks', 'impressions', 'ctr', 'position'])->toArray(),
                'top_pages' => SearchConsoleMetric::query()->when($searchPeriod, fn ($q) => $q->where('period_end', $searchPeriod))
                    ->where('metric_type', 'page')->orderByDesc('impressions')->limit(20)->get(['dimension', 'clicks', 'impressions', 'ctr', 'position'])->toArray(),
                'countries' => SearchConsoleMetric::query()->when($searchPeriod, fn ($q) => $q->where('period_end', $searchPeriod))
                    ->where('metric_type', 'country')->orderByDesc('impressions')->limit(12)->get(['dimension', 'clicks', 'impressions', 'ctr', 'position'])->toArray(),
            ],
            'existing_website_inventory' => ContentPage::published()
                ->whereIn('type', ['product', 'solution', 'service', 'industry', 'article', 'page'])
                ->orderBy('type')
                ->orderBy('sort_order')
                ->get()
                ->map(fn (ContentPage $page) => [
                    'type' => $page->type,
                    'slug' => $page->slug,
                    'title' => $page->translation('title', 'en'),
                    'summary' => mb_substr(strip_tags((string) $page->translation('summary', 'en')), 0, 220),
                    'primary_query' => $page->primaryQuery('en'),
                ])
                ->values()
                ->toArray(),
        ];

        try {
            $result = $advisor->generate($summary);

            AnalyticsAiInsight::query()->create([
                'provider' => $result['provider'],
                'model' => $result['model'],
                'content' => $result['content'],
                'input_summary' => $summary,
                'generated_by' => $request->user()?->id,
            ]);

            return back()->with('success', 'AI growth recommendations updated.');
        } catch (Throwable $exception) {
            report($exception);

            return back()->withErrors(['ai' => $exception->getMessage()]);
        }
    }

    public function importSearchConsole(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date', 'after_or_equal:period_start'],
            'files' => ['required', 'array', 'min:1'],
            'files.*' => ['file', 'max:2048'],
        ]);

        $mapping = [
            'top queries' => 'query',
            'top pages' => 'page',
            'country' => 'country',
            'device' => 'device',
            'date' => 'daily',
            'search appearance' => 'appearance',
        ];

        $inserted = 0;
        $rowsByType = [];

        foreach ($request->file('files', []) as $file) {
            $handle = fopen($file->getRealPath(), 'rb');
            if (! $handle) {
                continue;
            }

            $headers = fgetcsv($handle);
            if (! is_array($headers) || $headers === []) {
                fclose($handle);
                continue;
            }

            $headers = array_map(fn ($value) => trim((string) $value), $headers);
            $type = $mapping[mb_strtolower((string) ($headers[0] ?? ''))] ?? null;

            if (! $type) {
                fclose($handle);
                continue;
            }

            $rowsByType[$type] ??= [];

            while (($row = fgetcsv($handle)) !== false) {
                if (($row[0] ?? '') === '') {
                    continue;
                }

                $record = array_combine($headers, array_pad($row, count($headers), null));
                $ctr = rtrim(trim((string) ($record['CTR'] ?? '0')), '%');
                $rowsByType[$type][] = [
                    'metric_type' => $type,
                    'dimension' => mb_substr(trim((string) ($row[0] ?? '')), 0, 512),
                    'clicks' => (int) ($record['Clicks'] ?? 0),
                    'impressions' => (int) ($record['Impressions'] ?? 0),
                    'ctr' => is_numeric($ctr) ? ((float) $ctr / 100) : 0,
                    'position' => is_numeric($record['Position'] ?? null) ? (float) $record['Position'] : null,
                    'period_start' => $validated['period_start'],
                    'period_end' => $validated['period_end'],
                    'imported_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            fclose($handle);
        }

        DB::transaction(function () use ($rowsByType, $validated, &$inserted): void {
            foreach ($rowsByType as $type => $rows) {
                SearchConsoleMetric::query()
                    ->where('metric_type', $type)
                    ->where('period_start', $validated['period_start'])
                    ->where('period_end', $validated['period_end'])
                    ->delete();

                foreach (array_chunk($rows, 250) as $chunk) {
                    DB::table('search_console_metrics')->insert($chunk);
                    $inserted += count($chunk);
                }
            }
        });

        return back()->with('success', "Imported {$inserted} Search Console metrics.");
    }
}
