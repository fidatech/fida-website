<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\AnalyticsController;
use App\Models\SearchConsoleMetric;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\WebsiteAnalyticsEvent;
use App\Models\WebsitePageView;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DiagnoseAnalytics extends Command
{
    protected $signature = 'analytics:diagnose';
    protected $description = 'Run the production analytics queries used by the admin dashboard.';

    public function handle(): int
    {
        $from = now()->startOfDay()->subDays(29);
        $to = now()->endOfDay();

        $checks = [
            'human-count' => fn () => WebsitePageView::query()->where('is_bot', false)->whereBetween('occurred_at', [$from, $to])->count(),
            'visitors' => fn () => WebsitePageView::query()->where('is_bot', false)->whereBetween('occurred_at', [$from, $to])->distinct('visitor_key')->count('visitor_key'),
            'events' => fn () => WebsiteAnalyticsEvent::query()->whereBetween('occurred_at', [$from, $to])->count(),
            'daily' => fn () => WebsitePageView::query()->where('is_bot', false)->whereBetween('occurred_at', [$from, $to])->selectRaw('day, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors')->groupBy('day')->orderBy('day')->get()->count(),
            'pages' => fn () => WebsitePageView::query()->where('is_bot', false)->whereBetween('occurred_at', [$from, $to])->selectRaw('path, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors')->groupBy('path')->orderByDesc('views')->limit(15)->get()->count(),
            'sources' => fn () => WebsitePageView::query()->where('is_bot', false)->whereBetween('occurred_at', [$from, $to])->selectRaw("COALESCE(NULLIF(source, ''), 'direct') as source_name, COALESCE(NULLIF(medium, ''), 'direct') as medium_name, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors")->groupBy('source_name', 'medium_name')->orderByDesc('views')->limit(12)->get()->count(),
            'countries' => fn () => WebsitePageView::query()->where('is_bot', false)->whereBetween('occurred_at', [$from, $to])->selectRaw("COALESCE(country_code, '—') as country, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors")->groupBy('country')->orderByDesc('views')->limit(20)->get()->count(),
            'devices' => fn () => WebsitePageView::query()->where('is_bot', false)->whereBetween('occurred_at', [$from, $to])->selectRaw("COALESCE(device_type, 'unknown') as device, COUNT(*) as views")->groupBy('device')->orderByDesc('views')->get()->count(),
            'bots' => fn () => WebsitePageView::query()->where('is_bot', true)->whereBetween('occurred_at', [$from, $to])->selectRaw("COALESCE(bot_name, 'Other bot') as bot, COUNT(*) as hits")->groupBy('bot')->orderByDesc('hits')->limit(15)->get()->count(),
            'events-grouped' => fn () => WebsiteAnalyticsEvent::query()->whereBetween('occurred_at', [$from, $to])->selectRaw('event_name, COUNT(*) as total')->groupBy('event_name')->orderByDesc('total')->get()->count(),
            'search-period' => fn () => SearchConsoleMetric::query()->max('period_end'),
            'search-totals' => fn () => SearchConsoleMetric::query()->where('metric_type', 'device')->selectRaw('SUM(clicks) as clicks, SUM(impressions) as impressions')->first()?->toArray(),
            'search-opportunities' => fn () => SearchConsoleMetric::query()->where('metric_type', 'page')->where('impressions', '>=', 10)->whereBetween('position', [3, 15])->orderByDesc('impressions')->limit(12)->get()->count(),
        ];

        foreach ($checks as $name => $check) {
            try {
                $result = $check();
                $this->info($name.' OK '.json_encode($result));
            } catch (\Throwable $e) {
                $this->error($name.' FAILED: '.$e->getMessage());
                throw $e;
            }
        }

        $admin = User::query()->where('role', 'super_admin')->where('active', true)->first();
        if (! $admin) {
            $this->warn('render SKIPPED: no active super admin');
            return self::SUCCESS;
        }

        try {
            $request = Request::create('/admin/analytics?days=30', 'GET');
            $request->setUserResolver(fn () => $admin);
            $view = app(AnalyticsController::class)->index($request);
            $html = $view->render();
            $this->info('render OK '.strlen($html).' bytes');
        } catch (\Throwable $e) {
            $this->error('render FAILED: '.$e->getMessage());
            throw $e;
        }

        return self::SUCCESS;
    }
}
