<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SearchConsoleMetric;
use App\Models\WebsiteAnalyticsEvent;
use App\Models\WebsitePageView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request): View
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
            'bot_hits' => (clone $bots)->count(),
            'conversions' => WebsiteAnalyticsEvent::query()
                ->whereBetween('occurred_at', [$from, $to])
                ->whereIn('event_name', ['lead_submitted', 'cta_click'])
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
            ->limit(15)
            ->get();

        $sources = WebsitePageView::query()
            ->where('is_bot', false)
            ->whereBetween('occurred_at', [$from, $to])
            ->selectRaw("COALESCE(NULLIF(source, ''), 'direct') as source_name, COALESCE(NULLIF(medium, ''), 'direct') as medium_name, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors")
            ->groupBy('source_name', 'medium_name')
            ->orderByDesc('views')
            ->limit(12)
            ->get();

        $countries = WebsitePageView::query()
            ->where('is_bot', false)
            ->whereBetween('occurred_at', [$from, $to])
            ->selectRaw("COALESCE(country_code, '—') as country, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors")
            ->groupBy('country')
            ->orderByDesc('views')
            ->limit(20)
            ->get();

        $devices = WebsitePageView::query()
            ->where('is_bot', false)
            ->whereBetween('occurred_at', [$from, $to])
            ->selectRaw("COALESCE(device_type, 'unknown') as device, COUNT(*) as views")
            ->groupBy('device')
            ->orderByDesc('views')
            ->get();

        $botBreakdown = WebsitePageView::query()
            ->where('is_bot', true)
            ->whereBetween('occurred_at', [$from, $to])
            ->selectRaw("COALESCE(bot_name, 'Other bot') as bot, COUNT(*) as hits")
            ->groupBy('bot')
            ->orderByDesc('hits')
            ->limit(15)
            ->get();

        $events = WebsiteAnalyticsEvent::query()
            ->whereBetween('occurred_at', [$from, $to])
            ->selectRaw('event_name, COUNT(*) as total')
            ->groupBy('event_name')
            ->orderByDesc('total')
            ->get();

        $searchPeriod = SearchConsoleMetric::query()->max('period_end');
        $searchBase = SearchConsoleMetric::query();
        if ($searchPeriod) {
            $searchBase->where('period_end', $searchPeriod);
        }

        $search = [
            'period_end' => $searchPeriod ? Carbon::parse($searchPeriod) : null,
            'queries' => (clone $searchBase)->where('metric_type', 'query')->orderByDesc('impressions')->limit(20)->get(),
            'pages' => (clone $searchBase)->where('metric_type', 'page')->orderByDesc('impressions')->limit(20)->get(),
            'countries' => (clone $searchBase)->where('metric_type', 'country')->orderByDesc('impressions')->limit(20)->get(),
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
            ->whereBetween('position', [3, 15])
            ->orderByDesc('impressions')
            ->limit(12)
            ->get();

        return view('admin.analytics.index', compact(
            'days', 'from', 'to', 'summary', 'daily', 'topPages', 'sources',
            'countries', 'devices', 'botBreakdown', 'events', 'search'
        ));
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
        $typesSeen = [];
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
            $dimensionHeader = mb_strtolower((string) ($headers[0] ?? ''));
            $type = $mapping[$dimensionHeader] ?? null;

            if (! $type) {
                fclose($handle);
                continue;
            }

            $typesSeen[] = $type;
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
