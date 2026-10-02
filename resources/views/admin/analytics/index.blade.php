@extends('layouts.admin')

@section('title', 'Website analytics')
@section('eyebrow', 'Growth / audience intelligence')

@section('content')
    @php
        $maxDailyViews = max(1, (int) $daily->max('views'));
        $searchTotals = $search['totals'];
        $searchClicks = (int) ($searchTotals?->clicks ?? 0);
        $searchImpressions = (int) ($searchTotals?->impressions ?? 0);
        $searchCtr = $searchImpressions > 0 ? ($searchClicks / $searchImpressions) * 100 : 0;
    @endphp

    <section class="dashboard-intro analytics-heading">
        <div>
            <small class="section-code">AUDIENCE / SEARCH / BOTS / CONVERSIONS</small>
            <h1>Website intelligence</h1>
            <p>First-party visitor behavior plus imported Google Search Console performance. Human traffic and crawler traffic are separated.</p>
        </div>
        <form method="GET" class="analytics-range">
            <label>
                <span>Range</span>
                <select name="days" onchange="this.form.submit()">
                    @foreach([7, 14, 30, 60, 90, 180, 365] as $range)
                        <option value="{{ $range }}" @selected($days === $range)>Last {{ $range }} days</option>
                    @endforeach
                </select>
            </label>
        </form>
    </section>

    <section class="metric-grid analytics-metrics">
        <article class="metric-card metric-lime">
            <div><small>Human page views</small><strong>{{ number_format($summary['page_views']) }}</strong></div>
            <p>{{ number_format($summary['visitors']) }} unique visitors</p>
        </article>
        <article class="metric-card metric-cyan">
            <div><small>Sessions</small><strong>{{ number_format($summary['sessions']) }}</strong></div>
            <p>{{ $summary['visitors'] ? number_format($summary['page_views'] / $summary['visitors'], 1) : '0.0' }} pages per visitor</p>
        </article>
        <article class="metric-card metric-violet">
            <div><small>Tracked actions</small><strong>{{ number_format($summary['conversions']) }}</strong></div>
            <p>CTA clicks and submitted leads</p>
        </article>
        <article class="metric-card metric-orange">
            <div><small>Bot / crawler hits</small><strong>{{ number_format($summary['bot_hits']) }}</strong></div>
            <p>Search, AI and audit crawlers separated</p>
        </article>
    </section>

    <section class="console-card analytics-trend-card">
        <header>
            <div><small>01 / FIRST-PARTY TRAFFIC</small><h2>Human traffic trend</h2></div>
            <span>{{ $from->format('d M') }} — {{ $to->format('d M Y') }}</span>
        </header>
        <div class="analytics-bars" aria-label="Daily human page views">
            @forelse($daily as $point)
                <div class="analytics-bar-column" title="{{ $point->day }} · {{ $point->views }} views · {{ $point->visitors }} visitors">
                    <i style="height: {{ max(4, round(($point->views / $maxDailyViews) * 100)) }}%"></i>
                    <small>{{ date('d', strtotime((string) $point->day)) }}</small>
                </div>
            @empty
                <div class="empty-state"><i>↗</i><strong>Tracking starts now</strong><p>Human page views will begin appearing after this release is deployed.</p></div>
            @endforelse
        </div>
    </section>

    <section class="analytics-grid analytics-grid-2">
        <article class="console-card">
            <header><div><small>02 / CONTENT</small><h2>Most visited pages</h2></div></header>
            <div class="analytics-table-wrap">
                <table class="console-table analytics-table">
                    <thead><tr><th>Page</th><th>Views</th><th>Visitors</th></tr></thead>
                    <tbody>
                        @forelse($topPages as $row)
                            <tr><td><strong>{{ $row->path }}</strong></td><td>{{ number_format($row->views) }}</td><td>{{ number_format($row->visitors) }}</td></tr>
                        @empty
                            <tr><td colspan="3">No human page views in this range yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>

        <article class="console-card">
            <header><div><small>03 / ACQUISITION</small><h2>Traffic sources</h2></div></header>
            <div class="analytics-table-wrap">
                <table class="console-table analytics-table">
                    <thead><tr><th>Source</th><th>Medium</th><th>Views</th><th>Visitors</th></tr></thead>
                    <tbody>
                        @forelse($sources as $row)
                            <tr><td><strong>{{ $row->source_name }}</strong></td><td>{{ $row->medium_name }}</td><td>{{ number_format($row->views) }}</td><td>{{ number_format($row->visitors) }}</td></tr>
                        @empty
                            <tr><td colspan="4">No acquisition data yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>
    </section>

    <section class="analytics-grid analytics-grid-3">
        <article class="console-card">
            <header><div><small>04 / GEO</small><h2>Visitor countries</h2></div></header>
            <div class="analytics-table-wrap">
                <table class="console-table analytics-table">
                    <thead><tr><th>Country</th><th>Views</th><th>Visitors</th></tr></thead>
                    <tbody>
                        @forelse($countries as $row)
                            <tr><td><strong>{{ $row->country }}</strong></td><td>{{ number_format($row->views) }}</td><td>{{ number_format($row->visitors) }}</td></tr>
                        @empty
                            <tr><td colspan="3">Country is collected when the server/CDN supplies a country-code header.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>

        <article class="console-card">
            <header><div><small>05 / DEVICES</small><h2>Visitor devices</h2></div></header>
            <div class="analytics-pill-list">
                @forelse($devices as $row)
                    <div><span>{{ ucfirst($row->device) }}</span><strong>{{ number_format($row->views) }}</strong></div>
                @empty
                    <p class="analytics-note">No device data yet.</p>
                @endforelse
            </div>
        </article>

        <article class="console-card">
            <header><div><small>06 / EVENTS</small><h2>Business actions</h2></div></header>
            <div class="analytics-pill-list">
                @forelse($events as $row)
                    <div><span>{{ str($row->event_name)->replace('_', ' ')->title() }}</span><strong>{{ number_format($row->total) }}</strong></div>
                @empty
                    <p class="analytics-note">CTA, phone, email, WhatsApp and lead events will appear here.</p>
                @endforelse
            </div>
        </article>
    </section>

    <section class="console-card search-console-card">
        <header>
            <div>
                <small>07 / GOOGLE SEARCH CONSOLE</small>
                <h2>Organic search performance</h2>
                <p>Google usually hides search keywords from normal referrers, so query data comes from Search Console exports.</p>
            </div>
            @if($search['period_end'])<span>Through {{ $search['period_end']->format('d M Y') }}</span>@endif
        </header>

        <div class="search-kpis">
            <div><small>Clicks</small><strong>{{ number_format($searchClicks) }}</strong></div>
            <div><small>Impressions</small><strong>{{ number_format($searchImpressions) }}</strong></div>
            <div><small>CTR</small><strong>{{ number_format($searchCtr, 2) }}%</strong></div>
        </div>

        <div class="analytics-grid analytics-grid-2 search-grid">
            <div>
                <h3>Search queries</h3>
                <div class="analytics-table-wrap">
                    <table class="console-table analytics-table">
                        <thead><tr><th>Query</th><th>Clicks</th><th>Impr.</th><th>CTR</th><th>Pos.</th></tr></thead>
                        <tbody>
                            @forelse($search['queries'] as $row)
                                <tr>
                                    <td><strong>{{ $row->dimension }}</strong></td>
                                    <td>{{ $row->clicks }}</td>
                                    <td>{{ $row->impressions }}</td>
                                    <td>{{ number_format(((float) $row->ctr) * 100, 1) }}%</td>
                                    <td>{{ number_format((float) $row->position, 1) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5">Import Search Console CSV files below.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <h3>Search pages</h3>
                <div class="analytics-table-wrap">
                    <table class="console-table analytics-table">
                        <thead><tr><th>Page</th><th>Clicks</th><th>Impr.</th><th>CTR</th><th>Pos.</th></tr></thead>
                        <tbody>
                            @forelse($search['pages'] as $row)
                                <tr>
                                    <td><strong>{{ parse_url($row->dimension, PHP_URL_PATH) ?: $row->dimension }}</strong></td>
                                    <td>{{ $row->clicks }}</td>
                                    <td>{{ $row->impressions }}</td>
                                    <td>{{ number_format(((float) $row->ctr) * 100, 1) }}%</td>
                                    <td>{{ number_format((float) $row->position, 1) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5">No page metrics imported.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section class="analytics-grid analytics-grid-2">
        <article class="console-card opportunity-card">
            <header><div><small>08 / SEO OPPORTUNITIES</small><h2>Pages close to stronger visibility</h2></div></header>
            <p class="analytics-note">These are pages with at least 10 impressions and average position 3–15. High impressions with a weak CTR are good title/snippet and content-improvement candidates.</p>
            <div class="analytics-table-wrap">
                <table class="console-table analytics-table">
                    <thead><tr><th>Page</th><th>Impr.</th><th>CTR</th><th>Pos.</th></tr></thead>
                    <tbody>
                        @forelse($search['opportunities'] as $row)
                            <tr>
                                <td><strong>{{ parse_url($row->dimension, PHP_URL_PATH) ?: $row->dimension }}</strong></td>
                                <td>{{ $row->impressions }}</td>
                                <td>{{ number_format(((float) $row->ctr) * 100, 1) }}%</td>
                                <td>{{ number_format((float) $row->position, 1) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4">Import Search Console data to calculate opportunities.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>

        <article class="console-card">
            <header><div><small>09 / SEARCH MARKETS</small><h2>Countries in Google Search</h2></div></header>
            <div class="analytics-table-wrap">
                <table class="console-table analytics-table">
                    <thead><tr><th>Country</th><th>Clicks</th><th>Impr.</th><th>CTR</th><th>Pos.</th></tr></thead>
                    <tbody>
                        @forelse($search['countries'] as $row)
                            <tr>
                                <td><strong>{{ $row->dimension }}</strong></td>
                                <td>{{ $row->clicks }}</td>
                                <td>{{ $row->impressions }}</td>
                                <td>{{ number_format(((float) $row->ctr) * 100, 1) }}%</td>
                                <td>{{ number_format((float) $row->position, 1) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5">No country metrics imported.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>
    </section>

    <section class="analytics-grid analytics-grid-2">
        <article class="console-card">
            <header><div><small>10 / CRAWLERS</small><h2>Search & AI bots</h2></div></header>
            <div class="analytics-table-wrap">
                <table class="console-table analytics-table">
                    <thead><tr><th>Crawler</th><th>Hits</th></tr></thead>
                    <tbody>
                        @forelse($botBreakdown as $row)
                            <tr><td><strong>{{ $row->bot }}</strong></td><td>{{ number_format($row->hits) }}</td></tr>
                        @empty
                            <tr><td colspan="2">Bot visits will appear as crawlers reach the site.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>

        <article class="console-card import-card">
            <header><div><small>11 / DATA REFRESH</small><h2>Import Search Console CSVs</h2></div></header>
            <p class="analytics-note">Export Performance data from Google Search Console and select Queries.csv, Pages.csv, Countries.csv, Devices.csv, Chart.csv or Search appearance.csv. Existing rows for the same period/type are replaced.</p>
            <form method="POST" action="{{ route('admin.analytics.search-console.import') }}" enctype="multipart/form-data" class="analytics-import-form">
                @csrf
                <div class="analytics-form-grid">
                    <label><span>Period start</span><input type="date" name="period_start" value="{{ old('period_start', '2026-06-30') }}" required></label>
                    <label><span>Period end</span><input type="date" name="period_end" value="{{ old('period_end', now()->toDateString()) }}" required></label>
                </div>
                <label><span>CSV files</span><input type="file" name="files[]" accept=".csv,text/csv" multiple required></label>
                <button type="submit" class="console-button primary">Import search data <span>↗</span></button>
            </form>
        </article>
    </section>

    <p class="analytics-privacy-note">Privacy: first-party traffic stores a one-way hash of IP/session identifiers rather than the raw IP address. Country data is only recorded when the hosting/CDN layer supplies a country code.</p>
@endsection
