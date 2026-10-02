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
    @endphp

    <section class="analytics-hero">
        <div>
            <small class="section-code">REAL VISITORS · SEARCH DEMAND · AI RECOMMENDATIONS</small>
            <h1>Website analytics</h1>
            <p>Understand who is actually visiting Fida, what they care about, where they came from, which pages attract attention, and what to build or publish next.</p>
        </div>
        <form method="GET" class="analytics-range">
            <label>
                <span>Reporting period</span>
                <select name="days" onchange="this.form.submit()">
                    @foreach([7, 14, 30, 60, 90, 180, 365] as $range)
                        <option value="{{ $range }}" @selected($days === $range)>Last {{ $range }} days</option>
                    @endforeach
                </select>
            </label>
        </form>
    </section>

    <section class="analytics-summary-grid">
        <article class="analytics-stat">
            <span class="analytics-stat-icon">↗</span>
            <div><small>Real page views</small><strong>{{ number_format($summary['page_views']) }}</strong></div>
            <p>Human visits only; crawlers and automated audits are excluded.</p>
        </article>
        <article class="analytics-stat">
            <span class="analytics-stat-icon">◎</span>
            <div><small>Unique visitors</small><strong>{{ number_format($summary['visitors']) }}</strong></div>
            <p>{{ number_format($summary['active_15m']) }} active in the last 15 minutes.</p>
        </article>
        <article class="analytics-stat">
            <span class="analytics-stat-icon">◫</span>
            <div><small>Sessions</small><strong>{{ number_format($summary['sessions']) }}</strong></div>
            <p>{{ $summary['visitors'] ? number_format($summary['page_views'] / $summary['visitors'], 1) : '0.0' }} page views per visitor.</p>
        </article>
        <article class="analytics-stat">
            <span class="analytics-stat-icon">✓</span>
            <div><small>Business actions</small><strong>{{ number_format($summary['conversions']) }}</strong></div>
            <p>{{ number_format($conversionRate, 1) }}% actions per unique visitor.</p>
        </article>
    </section>

    <section class="analytics-section analytics-primary">
        <header class="analytics-section-head">
            <div>
                <small>FIRST-PARTY ANALYTICS</small>
                <h2>Real visitor activity</h2>
                <p>Collected directly by fida.af from public page requests. Bot and automation traffic is classified separately.</p>
            </div>
            <span class="analytics-live-badge"><i></i> Live tracking</span>
        </header>

        <div class="analytics-chart-card">
            <div class="analytics-chart-title">
                <div><strong>Traffic trend</strong><span>{{ $from->format('d M') }} — {{ $to->format('d M Y') }}</span></div>
                <span>Views / visitors</span>
            </div>
            <div class="analytics-bars" aria-label="Daily human page views">
                @forelse($daily as $point)
                    <div class="analytics-bar-column" title="{{ $point->day }} · {{ $point->views }} views · {{ $point->visitors }} visitors">
                        <i style="height: {{ max(4, round(($point->views / $maxDailyViews) * 100)) }}%"></i>
                        <small>{{ date('d', strtotime((string) $point->day)) }}</small>
                    </div>
                @empty
                    <div class="analytics-empty">Real visitor traffic will appear here as people browse the site.</div>
                @endforelse
            </div>
        </div>

        <div class="analytics-grid analytics-grid-2">
            <article class="analytics-panel">
                <header><div><small>CONTENT PERFORMANCE</small><h3>Most visited pages</h3></div></header>
                <div class="analytics-table-wrap">
                    <table class="analytics-data-table" data-datatable data-page-size="10">
                        <thead><tr><th data-sort>Page</th><th data-sort>Views</th><th data-sort>Visitors</th></tr></thead>
                        <tbody>
                            @forelse($topPages as $row)
                                <tr><td><strong>{{ $row->path }}</strong></td><td data-value="{{ $row->views }}">{{ number_format($row->views) }}</td><td data-value="{{ $row->visitors }}">{{ number_format($row->visitors) }}</td></tr>
                            @empty
                                <tr><td colspan="3">No real visitor page views in this period yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="analytics-panel">
                <header><div><small>ACQUISITION</small><h3>Traffic sources</h3></div></header>
                <div class="analytics-table-wrap">
                    <table class="analytics-data-table" data-datatable data-page-size="10">
                        <thead><tr><th data-sort>Source</th><th data-sort>Medium</th><th data-sort>Views</th><th data-sort>Visitors</th></tr></thead>
                        <tbody>
                            @forelse($sources as $row)
                                <tr>
                                    <td><strong>{{ $row->source_name }}</strong></td>
                                    <td><span class="analytics-chip">{{ $row->medium_name }}</span></td>
                                    <td data-value="{{ $row->views }}">{{ number_format($row->views) }}</td>
                                    <td data-value="{{ $row->visitors }}">{{ number_format($row->visitors) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4">No acquisition data yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </div>

        <div class="analytics-grid analytics-grid-2">
            <article class="analytics-panel">
                <header><div><small>VISITOR LOG</small><h3>Recent real visitors</h3></div></header>
                <div class="analytics-table-wrap">
                    <table class="analytics-data-table" data-datatable data-page-size="10">
                        <thead><tr><th data-sort>Visitor</th><th data-sort>Last seen</th><th data-sort>Pages</th><th data-sort>Country</th><th data-sort>Source</th><th data-sort>Device</th></tr></thead>
                        <tbody>
                            @forelse($recentVisitors as $row)
                                <tr>
                                    <td><span class="visitor-token">{{ strtoupper(substr($row->visitor_key, 0, 8)) }}</span></td>
                                    <td data-value="{{ strtotime((string) $row->last_seen) }}">{{ IlluminateSupportCarbon::parse($row->last_seen)->diffForHumans() }}</td>
                                    <td data-value="{{ $row->page_views }}">{{ number_format($row->page_views) }}</td>
                                    <td>{{ $row->country_code ?: 'Unknown' }}</td>
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

            <article class="analytics-panel">
                <header><div><small>AUDIENCE</small><h3>Countries</h3></div></header>
                <div class="analytics-table-wrap">
                    <table class="analytics-data-table" data-datatable data-page-size="10">
                        <thead><tr><th data-sort>Country</th><th data-sort>Views</th><th data-sort>Visitors</th></tr></thead>
                        <tbody>
                            @forelse($countries as $row)
                                <tr><td><strong>{{ $row->country }}</strong></td><td data-value="{{ $row->views }}">{{ number_format($row->views) }}</td><td data-value="{{ $row->visitors }}">{{ number_format($row->visitors) }}</td></tr>
                            @empty
                                <tr><td colspan="3">Country appears when the hosting/CDN supplies a country code.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </div>

        <div class="analytics-mini-grid">
            <article class="analytics-mini-panel">
                <small>Devices</small>
                @forelse($devices as $row)
                    <div><span>{{ ucfirst($row->device) }}</span><strong>{{ number_format($row->visitors) }} <em>visitors</em></strong></div>
                @empty
                    <p>No device data yet.</p>
                @endforelse
            </article>
            <article class="analytics-mini-panel">
                <small>Business actions</small>
                @forelse($events as $row)
                    <div><span>{{ str($row->event_name)->replace('_', ' ')->title() }}</span><strong>{{ number_format($row->total) }}</strong></div>
                @empty
                    <p>CTA, phone, email, WhatsApp and lead events will appear here.</p>
                @endforelse
            </article>
            <article class="analytics-mini-panel">
                <small>Automated traffic</small>
                <div><span>Bot / crawler hits</span><strong>{{ number_format($summary['bot_hits']) }}</strong></div>
                <p>Kept outside all real-visitor totals.</p>
            </article>
        </div>
    </section>

    <section class="analytics-section ai-advisor-section">
        <header class="analytics-section-head">
            <div>
                <small>AI GROWTH ADVISOR</small>
                <h2>What should Fida work on next?</h2>
                <p>The advisor combines real visitor behavior with Google Search Console demand to suggest ERP products, commercial topics, pages to improve and conversion actions.</p>
            </div>
            @if($aiConfigured)
                <form method="POST" action="{{ route('admin.analytics.ai-insight') }}">
                    @csrf
                    <input type="hidden" name="days" value="{{ $days }}">
                    <button class="console-button console-button-primary" type="submit">Generate recommendations <span>✦</span></button>
                </form>
            @else
                <a href="{{ route('admin.settings.edit') }}" class="console-button console-button-primary">Connect AI API <span>↗</span></a>
            @endif
        </header>

        <div class="ai-advisor-grid">
            <article class="ai-opportunity-card">
                <span class="ai-kicker">DATA-DRIVEN NOW</span>
                <h3>Search opportunities already visible</h3>
                <div class="ai-opportunity-list">
                    @forelse($search['opportunities']->take(6) as $row)
                        <div>
                            <span>{{ parse_url($row->dimension, PHP_URL_PATH) ?: $row->dimension }}</span>
                            <small>{{ number_format($row->impressions) }} impressions · {{ number_format(((float) $row->ctr) * 100, 1) }}% CTR · position {{ number_format((float) $row->position, 1) }}</small>
                        </div>
                    @empty
                        <p>Import Search Console data to identify high-impression pages that are close to stronger rankings.</p>
                    @endforelse
                </div>
            </article>

            <article class="ai-response-card">
                <div class="ai-response-head">
                    <div>
                        <span class="ai-kicker">AI ANALYSIS</span>
                        <h3>{{ $latestInsight ? 'Latest growth recommendation' : 'Connect an AI provider' }}</h3>
                    </div>
                    @if($latestInsight)
                        <small>{{ strtoupper($latestInsight->provider) }} · {{ $latestInsight->model }} · {{ $latestInsight->created_at->diffForHumans() }}</small>
                    @endif
                </div>
                @if($latestInsight)
                    <div class="ai-response-copy">{{ $latestInsight->content }}</div>
                @elseif($aiConfigured)
                    <div class="analytics-empty">Your API is connected. Generate the first recommendation to analyze ERP, topic and conversion opportunities.</div>
                @else
                    <div class="analytics-empty">
                        Add a Gemini or OpenRouter API key in Settings. Only aggregated analytics are sent to the provider—no visitor IDs, IP hashes or raw user-agent strings.
                    </div>
                @endif
                @error('ai')<div class="ai-error">{{ $message }}</div>@enderror
            </article>
        </div>
    </section>

    <section class="analytics-section search-intelligence-section">
        <header class="analytics-section-head">
            <div>
                <small>GOOGLE SEARCH CONSOLE</small>
                <h2>Search visibility</h2>
                <p>This is Google search-result data, not website visitor tracking. Google normally does not reveal the exact organic query in a visitor's HTTP referrer, so keyword performance is kept here as a separate dataset.</p>
            </div>
            @if($search['period_end'])<span class="analytics-period">Through {{ $search['period_end']->format('d M Y') }}</span>@endif
        </header>

        <div class="search-kpis">
            <div><small>Clicks</small><strong>{{ number_format($searchClicks) }}</strong></div>
            <div><small>Impressions</small><strong>{{ number_format($searchImpressions) }}</strong></div>
            <div><small>CTR</small><strong>{{ number_format($searchCtr, 2) }}%</strong></div>
        </div>

        <div class="analytics-grid analytics-grid-2">
            <article class="analytics-panel">
                <header><div><small>KEYWORDS</small><h3>Search queries</h3></div></header>
                <div class="analytics-table-wrap">
                    <table class="analytics-data-table" data-datatable data-page-size="10">
                        <thead><tr><th data-sort>Query</th><th data-sort>Clicks</th><th data-sort>Impressions</th><th data-sort>CTR</th><th data-sort>Position</th></tr></thead>
                        <tbody>
                            @forelse($search['queries'] as $row)
                                <tr>
                                    <td><strong>{{ $row->dimension }}</strong></td>
                                    <td data-value="{{ $row->clicks }}">{{ $row->clicks }}</td>
                                    <td data-value="{{ $row->impressions }}">{{ $row->impressions }}</td>
                                    <td data-value="{{ (float) $row->ctr }}">{{ number_format(((float) $row->ctr) * 100, 1) }}%</td>
                                    <td data-value="{{ (float) $row->position }}">{{ number_format((float) $row->position, 1) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5">Import Search Console CSV files below.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="analytics-panel">
                <header><div><small>LANDING PAGES</small><h3>Pages in Google Search</h3></div></header>
                <div class="analytics-table-wrap">
                    <table class="analytics-data-table" data-datatable data-page-size="10">
                        <thead><tr><th data-sort>Page</th><th data-sort>Clicks</th><th data-sort>Impressions</th><th data-sort>CTR</th><th data-sort>Position</th></tr></thead>
                        <tbody>
                            @forelse($search['pages'] as $row)
                                <tr>
                                    <td><strong>{{ parse_url($row->dimension, PHP_URL_PATH) ?: $row->dimension }}</strong></td>
                                    <td data-value="{{ $row->clicks }}">{{ $row->clicks }}</td>
                                    <td data-value="{{ $row->impressions }}">{{ $row->impressions }}</td>
                                    <td data-value="{{ (float) $row->ctr }}">{{ number_format(((float) $row->ctr) * 100, 1) }}%</td>
                                    <td data-value="{{ (float) $row->position }}">{{ number_format((float) $row->position, 1) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5">No Search Console page metrics imported.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </div>

        <div class="analytics-grid analytics-grid-2">
            <article class="analytics-panel">
                <header><div><small>SEARCH MARKETS</small><h3>Countries in Google Search</h3></div></header>
                <div class="analytics-table-wrap">
                    <table class="analytics-data-table" data-datatable data-page-size="10">
                        <thead><tr><th data-sort>Country</th><th data-sort>Clicks</th><th data-sort>Impressions</th><th data-sort>CTR</th><th data-sort>Position</th></tr></thead>
                        <tbody>
                            @forelse($search['countries'] as $row)
                                <tr>
                                    <td><strong>{{ $row->dimension }}</strong></td>
                                    <td data-value="{{ $row->clicks }}">{{ $row->clicks }}</td>
                                    <td data-value="{{ $row->impressions }}">{{ $row->impressions }}</td>
                                    <td data-value="{{ (float) $row->ctr }}">{{ number_format(((float) $row->ctr) * 100, 1) }}%</td>
                                    <td data-value="{{ (float) $row->position }}">{{ number_format((float) $row->position, 1) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5">No Search Console country metrics imported.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="analytics-panel">
                <header><div><small>CRAWLERS</small><h3>Search & AI bots</h3></div></header>
                <div class="analytics-table-wrap">
                    <table class="analytics-data-table" data-datatable data-page-size="10">
                        <thead><tr><th data-sort>Crawler / automation</th><th data-sort>Hits</th></tr></thead>
                        <tbody>
                            @forelse($botBreakdown as $row)
                                <tr><td><strong>{{ $row->bot }}</strong></td><td data-value="{{ $row->hits }}">{{ number_format($row->hits) }}</td></tr>
                            @empty
                                <tr><td colspan="2">Crawler activity will appear here.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </div>

        <article class="analytics-panel search-import-panel">
            <header><div><small>SEARCH DATA REFRESH</small><h3>Import Search Console CSVs</h3></div></header>
            <div class="search-import-layout">
                <p>Export Performance data from Google Search Console and select Queries.csv, Pages.csv, Countries.csv, Devices.csv, Chart.csv or Search appearance.csv. Existing rows for the same period and type are replaced.</p>
                <form method="POST" action="{{ route('admin.analytics.search-console.import') }}" enctype="multipart/form-data" class="analytics-import-form">
                    @csrf
                    <div class="analytics-form-grid">
                        <label><span>Period start</span><input type="date" name="period_start" value="{{ old('period_start', '2026-06-30') }}" required></label>
                        <label><span>Period end</span><input type="date" name="period_end" value="{{ old('period_end', now()->toDateString()) }}" required></label>
                    </div>
                    <label><span>CSV files</span><input type="file" name="files[]" accept=".csv,text/csv" multiple required></label>
                    <button type="submit" class="console-button console-button-primary">Import search data <span>↗</span></button>
                </form>
            </div>
        </article>
    </section>

    <p class="analytics-privacy-note">First-party analytics stores one-way hashes rather than raw visitor IP addresses. Automated deployment checks, HTTP clients, bots and crawlers are excluded from real-visitor totals.</p>
@endsection
