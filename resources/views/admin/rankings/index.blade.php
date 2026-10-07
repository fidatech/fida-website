@extends('layouts.admin')

@section('title', 'Ranking monitor')
@section('eyebrow', 'Growth / search visibility')

@section('content')
    <section class="page-heading">
        <div>
            <small class="section-code">01 / SEARCH VISIBILITY</small>
            <h1>Know which keywords are moving.</h1>
            <p>Track priority English, Dari and Pashto queries against imported Google Search Console data and focus on the pages closest to stronger positions.</p>
        </div>
        <a class="console-button console-button-quiet" href="{{ route('admin.analytics.index') }}">Open analytics <span>↗</span></a>
    </section>

    <div class="website-settings-layout">
        <div class="website-settings-main">
            <section class="console-card table-card">
                <header><div><small>TRACKED KEYWORDS</small><h2>Priority search terms</h2></div></header>
                <div class="console-table-wrap">
                    <table class="console-table">
                        <thead><tr><th>Keyword</th><th>Locale</th><th>Impressions</th><th>Clicks</th><th>Position</th><th>Change</th><th>Target</th></tr></thead>
                        <tbody>
                            @forelse($rows as $row)
                                <tr>
                                    <td><span class="table-title"><strong>{{ $row['target']->keyword }}</strong><small>{{ $row['target']->target_url ?: 'No target URL' }}</small></span></td>
                                    <td><span class="type-label">{{ strtoupper($row['target']->locale) }}</span></td>
                                    <td>{{ number_format((int) ($row['latest']?->impressions ?? 0)) }}</td>
                                    <td>{{ number_format((int) ($row['latest']?->clicks ?? 0)) }}</td>
                                    <td>{{ $row['latest']?->position ? number_format((float) $row['latest']->position, 1) : '—' }}</td>
                                    <td>@if($row['position_delta'] !== null)<span class="status {{ $row['position_delta'] >= 0 ? 'status-published' : 'status-lost' }}">{{ $row['position_delta'] > 0 ? '+' : '' }}{{ number_format($row['position_delta'], 1) }}</span>@else—@endif</td>
                                    <td>#{{ number_format((float) $row['target']->target_position, 1) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="7"><div class="empty-state"><i>◎</i><strong>No tracked keywords yet</strong><p>Add the keywords that matter most to Fida.</p></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="console-card table-card">
                <header><div><small>QUICK WINS</small><h2>Queries currently in positions 3–25</h2></div></header>
                <div class="console-table-wrap">
                    <table class="console-table">
                        <thead><tr><th>Query</th><th>Clicks</th><th>Impressions</th><th>CTR</th><th>Position</th></tr></thead>
                        <tbody>
                            @forelse($opportunities as $metric)
                                <tr><td><strong>{{ $metric->dimension }}</strong></td><td>{{ $metric->clicks }}</td><td>{{ $metric->impressions }}</td><td>{{ number_format((float) $metric->ctr * 100, 1) }}%</td><td>{{ number_format((float) $metric->position, 1) }}</td></tr>
                            @empty
                                <tr><td colspan="5"><div class="empty-state"><i>↗</i><strong>No ranking opportunities available</strong><p>Import fresh Search Console data from Analytics.</p></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <aside class="website-settings-side">
            <section class="console-card settings-panel">
                <header><div><small>ADD TARGET</small><h2>Track a keyword</h2></div></header>
                <form class="settings-panel-body console-form" method="POST" action="{{ route('admin.rankings.store') }}">
                    @csrf
                    <label><span>Keyword</span><input name="keyword" required placeholder="erp systems afghanistan"></label>
                    <div class="console-form two-columns compact-fields">
                        <label><span>Language</span><select name="locale"><option value="en">English</option><option value="fa">Dari</option><option value="ps">Pashto</option></select></label>
                        <label><span>Target</span><input type="number" step="0.1" min="1" max="100" name="target_position" value="3" required></label>
                    </div>
                    <label><span>Target URL</span><input name="target_url" placeholder="/erp-systems-afghanistan"></label>
                    <label><span>Notes</span><textarea name="notes" rows="3"></textarea></label>
                    <button class="console-button console-button-primary" type="submit">Track keyword <span>+</span></button>
                </form>
            </section>

            <section class="console-card settings-panel">
                <header><div><small>DATA PERIOD</small><h2>Search Console</h2></div><span class="settings-state">{{ $latest ? 'READY' : 'EMPTY' }}</span></header>
                <div class="settings-panel-body">
                    <div class="admin-fact-list">
                        <div><span>Latest</span><strong>{{ $latest ? $latest->period_start->format('d M').' → '.$latest->period_end->format('d M Y') : 'No data' }}</strong></div>
                        <div><span>Previous</span><strong>{{ $previous ? $previous->period_start->format('d M').' → '.$previous->period_end->format('d M Y') : 'No comparison' }}</strong></div>
                    </div>
                </div>
            </section>
        </aside>
    </div>
@endsection
