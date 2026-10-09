@extends('layouts.admin')

@section('title', 'Analytics')
@section('eyebrow', 'Audience intelligence')

@section('content')
    @php
        $maxDailyViews = max(1, (int) $daily->max('views'));
        $searchTotals = $search['totals'];
        $searchClicks = (int) ($searchTotals?->clicks ?? 0);
        $searchImpressions = (int) ($searchTotals?->impressions ?? 0);
        $searchCtr = $searchImpressions > 0 ? ($searchClicks / $searchImpressions) * 100 : 0;
        $conversionRate = $summary['visitors'] > 0 ? ($summary['conversions'] / $summary['visitors']) * 100 : 0;
        $countryCoverage = $summary['visitors'] > 0
            ? ($summary['country_known_visitors'] / $summary['visitors']) * 100
            : 0;
        $aiDecision = $latestInsight ? json_decode((string) $latestInsight->content, true) : null;
        $aiDecision = is_array($aiDecision) && !empty($aiDecision['priorities']) ? $aiDecision : null;
    @endphp

    <section class="analytics-hero analytics-hero-clean">
        <div>
            <small class="section-code">FIDA FIRST-PARTY INTELLIGENCE</small>
            <h1>Analytics that answers business questions.</h1>
            <p>Real visitors, markets, acquisition, content performance and search demand — without mixing crawlers into human traffic.</p>
        </div>
        <form method="GET" class="analytics-range">
            <label>
                <span>Period</span>
                <select name="days" onchange="this.form.submit()">
                    @foreach([7, 14, 30, 60, 90, 180, 365] as $range)
                        <option value="{{ $range }}" @selected($days === $range)>Last {{ $range }} days</option>
                    @endforeach
                </select>
            </label>
        </form>
    </section>

    <section class="analytics-summary-grid analytics-summary-clean">
        <article class="analytics-stat">
            <span class="analytics-stat-icon">◎</span>
            <div><small>Visitors</small><strong>{{ number_format($summary['visitors']) }}</strong></div>
            <p>{{ number_format($summary['active_15m']) }} active in the last 15 minutes.</p>
        </article>
        <article class="analytics-stat">
            <span class="analytics-stat-icon">↗</span>
            <div><small>Page views</small><strong>{{ number_format($summary['page_views']) }}</strong></div>
            <p>{{ $summary['visitors'] ? number_format($summary['page_views'] / $summary['visitors'], 1) : '0.0' }} views per visitor.</p>
        </article>
        <article class="analytics-stat">
            <span class="analytics-stat-icon">◫</span>
            <div><small>Sessions</small><strong>{{ number_format($summary['sessions']) }}</strong></div>
            <p>Human browsing sessions in this reporting period.</p>
        </article>
        <article class="analytics-stat">
            <span class="analytics-stat-icon">✓</span>
            <div><small>Business actions</small><strong>{{ number_format($summary['conversions']) }}</strong></div>
            <p>{{ number_format($conversionRate, 1) }}% actions per unique visitor.</p>
        </article>
    </section>

    <section class="analytics-section analytics-primary analytics-section-clean">
        <header class="analytics-section-head">
            <div>
                <small>OVERVIEW</small>
                <h2>Traffic trend</h2>
                <p>{{ $from->format('d M') }} — {{ $to->format('d M Y') }} · bots excluded from every figure below.</p>
            </div>
            <span class="analytics-live-badge"><i></i> Live first-party tracking</span>
        </header>

        <div class="analytics-chart-card analytics-chart-clean">
            <div class="analytics-bars" aria-label="Daily human page views">
                @forelse($daily as $point)
                    <div class="analytics-bar-column" title="{{ $point->day }} · {{ $point->views }} views · {{ $point->visitors }} visitors">
                        <i style="height: {{ max(4, round(($point->views / $maxDailyViews) * 100)) }}%"></i>
                        <small>{{ date('d', strtotime((string) $point->day)) }}</small>
                    </div>
                @empty
                    <div class="analytics-empty">Traffic will appear here as real visitors browse the website.</div>
                @endforelse
            </div>
        </div>

        <div class="analytics-overview-grid">
            <article class="analytics-panel analytics-market-panel">
                <header>
                    <div><small>AUDIENCE</small><h3>Top countries</h3></div>
                    <span class="country-coverage">{{ number_format($countryCoverage, 0) }}% identified</span>
                </header>
                @if($summary['country_known_visitors'] === 0 && $summary['visitors'] > 0)
                    <div class="analytics-data-warning">
                        <strong>Country detection is not reaching PHP yet.</strong>
                        <span>Fida now supports Cloudflare, CloudFront, Vercel and common GeoIP server headers. Existing visits cannot be backfilled; new visits will populate countries when the hosting/CDN provides a country header.</span>
                    </div>
                @endif
                <div class="analytics-table-wrap">
                    <table class="analytics-data-table" data-datatable data-page-size="10">
                        <thead><tr><th data-sort>Country</th><th data-sort>Visitors</th><th data-sort>Views</th></tr></thead>
                        <tbody>
                            @forelse($countries as $row)
                                <tr>
                                    <td><strong class="country-label"><span data-country-flag="{{ $row->country }}"></span><span data-country-name="{{ $row->country }}">{{ $row->country }}</span></strong></td>
                                    <td data-value="{{ $row->visitors }}">{{ number_format($row->visitors) }}</td>
                                    <td data-value="{{ $row->views }}">{{ number_format($row->views) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3">No country data has been received yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="analytics-panel">
                <header><div><small>ACQUISITION</small><h3>Where visitors come from</h3></div></header>
                <div class="analytics-table-wrap">
                    <table class="analytics-data-table" data-datatable data-page-size="10">
                        <thead><tr><th data-sort>Source</th><th data-sort>Medium</th><th data-sort>Visitors</th></tr></thead>
                        <tbody>
                            @forelse($sources as $row)
                                <tr>
                                    <td><strong>{{ $row->source_name }}</strong></td>
                                    <td><span class="analytics-chip">{{ $row->medium_name }}</span></td>
                                    <td data-value="{{ $row->visitors }}">{{ number_format($row->visitors) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3">No acquisition data yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="analytics-panel">
                <header><div><small>CONTENT</small><h3>Pages people actually visit</h3></div></header>
                <div class="analytics-table-wrap">
                    <table class="analytics-data-table" data-datatable data-page-size="10">
                        <thead><tr><th data-sort>Page</th><th data-sort>Visitors</th><th data-sort>Views</th></tr></thead>
                        <tbody>
                            @forelse($topPages as $row)
                                <tr>
                                    <td><strong>{{ $row->path }}</strong></td>
                                    <td data-value="{{ $row->visitors }}">{{ number_format($row->visitors) }}</td>
                                    <td data-value="{{ $row->views }}">{{ number_format($row->views) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3">No page data yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </div>

        <div class="analytics-mini-grid analytics-mini-clean">
            <article class="analytics-mini-panel">
                <small>Devices</small>
                @forelse($devices as $row)
                    <div><span>{{ ucfirst($row->device) }}</span><strong>{{ number_format($row->visitors) }}</strong></div>
                @empty
                    <p>No device data yet.</p>
                @endforelse
            </article>
            <article class="analytics-mini-panel">
                <small>Actions</small>
                @forelse($events->take(6) as $row)
                    <div><span>{{ str($row->event_name)->replace('_', ' ')->title() }}</span><strong>{{ number_format($row->total) }}</strong></div>
                @empty
                    <p>Lead, RFQ, CTA, phone, email and WhatsApp actions will appear here.</p>
                @endforelse
            </article>
            <article class="analytics-mini-panel">
                <small>Automation filtered out</small>
                <div><span>Bot / crawler hits</span><strong>{{ number_format($summary['bot_hits']) }}</strong></div>
                <p>These hits are intentionally excluded from visitor totals.</p>
            </article>
        </div>
    </section>

    <section class="analytics-section analytics-section-clean">
        <header class="analytics-section-head">
            <div>
                <small>RECENT ACTIVITY</small>
                <h2>Latest real visitors</h2>
                <p>A compact session-level view for checking new traffic without exposing raw IP addresses.</p>
            </div>
        </header>
        <article class="analytics-panel">
            <div class="analytics-table-wrap">
                <table class="analytics-data-table" data-datatable data-page-size="10">
                    <thead><tr><th data-sort>Visitor</th><th data-sort>Last seen</th><th data-sort>Pages</th><th data-sort>Country</th><th data-sort>Source</th><th data-sort>Device</th></tr></thead>
                    <tbody>
                        @forelse($recentVisitors as $row)
                            <tr>
                                <td><span class="visitor-token">{{ strtoupper(substr($row->visitor_key, 0, 8)) }}</span></td>
                                <td data-value="{{ strtotime((string) $row->last_seen) }}">{{ date('d M Y H:i', strtotime((string) $row->last_seen)) }}</td>
                                <td data-value="{{ $row->page_views }}">{{ number_format($row->page_views) }}</td>
                                <td>
                                    @if($row->country_code)
                                        <span class="country-label"><span data-country-flag="{{ $row->country_code }}"></span><span data-country-name="{{ $row->country_code }}">{{ $row->country_code }}</span></span>
                                    @else
                                        <span class="analytics-muted">Unknown</span>
                                    @endif
                                </td>
                                <td>{{ $row->source_name ?: 'direct' }}</td>
                                <td>{{ ucfirst($row->device_type ?: 'unknown') }} · {{ $row->browser ?: 'Other' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6">No real visitors in this period yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>
    </section>

    <section class="analytics-section analytics-section-clean">
        <header class="analytics-section-head">
            <div>
                <small>GOOGLE SEARCH CONSOLE</small>
                <h2>Search visibility</h2>
                <p>Search demand is kept separate from website traffic so rankings, impressions and clicks stay easy to understand.</p>
            </div>
            @if($search['period_end'])<span class="analytics-period">Through {{ $search['period_end']->format('d M Y') }}</span>@endif
        </header>

        <div class="search-kpis analytics-search-kpis">
            <div><small>Clicks</small><strong>{{ number_format($searchClicks) }}</strong></div>
            <div><small>Impressions</small><strong>{{ number_format($searchImpressions) }}</strong></div>
            <div><small>CTR</small><strong>{{ number_format($searchCtr, 2) }}%</strong></div>
        </div>

        <div class="analytics-grid analytics-grid-2">
            <article class="analytics-panel">
                <header><div><small>KEYWORDS</small><h3>Top search queries</h3></div></header>
                <div class="analytics-table-wrap">
                    <table class="analytics-data-table" data-datatable data-page-size="10">
                        <thead><tr><th data-sort>Query</th><th data-sort>Clicks</th><th data-sort>Impressions</th><th data-sort>Position</th></tr></thead>
                        <tbody>
                            @forelse($search['queries'] as $row)
                                <tr>
                                    <td><strong>{{ $row->dimension }}</strong></td>
                                    <td data-value="{{ $row->clicks }}">{{ $row->clicks }}</td>
                                    <td data-value="{{ $row->impressions }}">{{ $row->impressions }}</td>
                                    <td data-value="{{ (float) $row->position }}">{{ number_format((float) $row->position, 1) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4">Import Search Console CSV files to populate search intelligence.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="analytics-panel">
                <header><div><small>SEARCH PAGES</small><h3>Landing pages in Google</h3></div></header>
                <div class="analytics-table-wrap">
                    <table class="analytics-data-table" data-datatable data-page-size="10">
                        <thead><tr><th data-sort>Page</th><th data-sort>Clicks</th><th data-sort>Impressions</th><th data-sort>Position</th></tr></thead>
                        <tbody>
                            @forelse($search['pages'] as $row)
                                <tr>
                                    <td><strong>{{ parse_url($row->dimension, PHP_URL_PATH) ?: $row->dimension }}</strong></td>
                                    <td data-value="{{ $row->clicks }}">{{ $row->clicks }}</td>
                                    <td data-value="{{ $row->impressions }}">{{ $row->impressions }}</td>
                                    <td data-value="{{ (float) $row->position }}">{{ number_format((float) $row->position, 1) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4">No Search Console page data imported yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </div>

        <details class="analytics-advanced">
            <summary>Import / refresh Search Console data</summary>
            <div class="analytics-advanced-body">
                <form method="POST" action="{{ route('admin.analytics.search-console.import') }}" enctype="multipart/form-data" class="analytics-import-form">
                    @csrf
                    <div class="analytics-form-grid">
                        <label><span>Period start</span><input type="date" name="period_start" value="{{ old('period_start', now()->subDays(28)->toDateString()) }}" required></label>
                        <label><span>Period end</span><input type="date" name="period_end" value="{{ old('period_end', now()->toDateString()) }}" required></label>
                    </div>
                    <label><span>CSV files</span><input type="file" name="files[]" accept=".csv,text/csv" multiple required></label>
                    <button type="submit" class="console-button console-button-primary">Import search data <span>↗</span></button>
                </form>
            </div>
        </details>
    </section>

    <section class="analytics-section analytics-section-clean analytics-secondary-intelligence">
        <header class="analytics-section-head">
            <div>
                <small>AI & DISCOVERY</small>
                <h2>Signals worth watching</h2>
                <p>AI referrals, AI crawler activity and the growth advisor live here instead of cluttering the main traffic dashboard.</p>
            </div>
            @if($aiConfigured)
                <form method="POST" action="{{ route('admin.analytics.ai-insight') }}">
                    @csrf
                    <input type="hidden" name="days" value="{{ $days }}">
                    <button class="console-button console-button-primary" type="submit">Generate owner brief <span>✦</span></button>
                </form>
            @endif
        </header>

        <div class="search-kpis">
            <div><small>AI referral views</small><strong>{{ number_format($aiVisibility['views']) }}</strong></div>
            <div><small>AI visitors</small><strong>{{ number_format($aiVisibility['visitors']) }}</strong></div>
            <div><small>AI crawler hits</small><strong>{{ number_format($aiVisibility['crawler_hits']) }}</strong></div>
        </div>

        @if($aiDecision)
            <div class="analytics-owner-brief">
                <div>
                    <small>OWNER BRIEF</small>
                    <h3>{{ $aiDecision['headline'] ?? 'Recommended next actions' }}</h3>
                    @if(!empty($aiDecision['summary']))<p>{{ $aiDecision['summary'] }}</p>@endif
                </div>
                <div class="analytics-owner-priorities">
                    @foreach(array_slice($aiDecision['priorities'], 0, 3) as $priority)
                        <article>
                            <span>{{ $priority['type'] ?? 'Action' }}</span>
                            <strong>{{ $priority['title'] ?? 'Next action' }}</strong>
                            <p>{{ $priority['decision'] ?? ($priority['business_reason'] ?? '') }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        @elseif(!$aiConfigured)
            <div class="analytics-data-warning compact">
                <strong>AI advisor is optional.</strong>
                <span>Connect an AI provider in Brand & settings only if you want automatic owner recommendations. Core analytics works without it.</span>
            </div>
        @endif

        <details class="analytics-advanced">
            <summary>Show AI referrals, crawler breakdown and search-market details</summary>
            <div class="analytics-advanced-body analytics-grid analytics-grid-2">
                <article class="analytics-panel">
                    <header><div><small>AI REFERRALS</small><h3>Assistant traffic</h3></div></header>
                    <div class="analytics-table-wrap">
                        <table class="analytics-data-table" data-datatable data-page-size="10">
                            <thead><tr><th data-sort>Source</th><th data-sort>Views</th><th data-sort>Visitors</th></tr></thead>
                            <tbody>
                                @forelse($aiVisibility['providers'] as $row)
                                    <tr><td><strong>{{ $row->provider }}</strong></td><td>{{ number_format($row->views) }}</td><td>{{ number_format($row->visitors) }}</td></tr>
                                @empty
                                    <tr><td colspan="3">No recognized AI referrals yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </article>
                <article class="analytics-panel">
                    <header><div><small>CRAWLERS</small><h3>Search & AI bots</h3></div></header>
                    <div class="analytics-table-wrap">
                        <table class="analytics-data-table" data-datatable data-page-size="10">
                            <thead><tr><th data-sort>Bot</th><th data-sort>Hits</th></tr></thead>
                            <tbody>
                                @forelse($botBreakdown as $row)
                                    <tr><td><strong>{{ $row->bot }}</strong></td><td data-value="{{ $row->hits }}">{{ number_format($row->hits) }}</td></tr>
                                @empty
                                    <tr><td colspan="2">No crawler activity recorded.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </article>
            </div>
        </details>
    </section>

    <p class="analytics-privacy-note">Privacy: Fida stores one-way visitor/IP hashes rather than raw IP addresses. Country is saved only as a two-letter country code when the hosting/CDN makes that information available.</p>
@endsection
