@extends('layouts.admin')

@section('title', 'Ranking Monitor')
@section('eyebrow', 'Growth / search visibility')

@section('content')
<section class="editor-heading">
    <div><small class="section-code">GOOGLE SEARCH CONSOLE</small><h1>Ranking monitor</h1><p>Track priority English, Dari and Pashto keywords against the latest imported Search Console period and compare movement with the previous period.</p></div>
    <a class="console-button console-button-quiet" href="{{ route('admin.analytics.index') }}">Import Search Console ↗</a>
</section>

<div class="admin-grid-two">
<section class="console-card admin-card-pad">
    <h2>Add tracked keyword</h2>
    <form class="console-form" method="POST" action="{{ route('admin.rankings.store') }}">@csrf
        <label><span>Keyword</span><input name="keyword" required placeholder="erp systems afghanistan"></label>
        <div class="console-form two-columns">
            <label><span>Language</span><select name="locale"><option value="en">English</option><option value="fa">Dari</option><option value="ps">Pashto</option></select></label>
            <label><span>Target position</span><input type="number" step="0.1" min="1" max="100" name="target_position" value="3" required></label>
        </div>
        <label><span>Target URL</span><input name="target_url" placeholder="/erp-systems-afghanistan"></label>
        <label><span>Notes</span><textarea name="notes" rows="3"></textarea></label>
        <button class="console-button console-button-primary" type="submit">Track keyword</button>
    </form>
</section>
<section class="console-card admin-card-pad">
    <div class="growth-status"><span class="{{ $latest ? 'status-good' : 'status-warn' }}">{{ $latest ? 'DATA READY' : 'IMPORT REQUIRED' }}</span><h2>Search Console periods</h2><dl>
        <div><dt>Latest</dt><dd>{{ $latest ? $latest->period_start.' → '.$latest->period_end : 'No data' }}</dd></div>
        <div><dt>Previous</dt><dd>{{ $previous ? $previous->period_start.' → '.$previous->period_end : 'No comparison yet' }}</dd></div>
    </dl></div>
</section>
</div>

<section class="console-card table-card"><header><div><small>Priority keywords</small><h2>Tracked rankings</h2></div></header>
<div class="analytics-table-wrap"><table data-datatable data-page-size="25"><thead><tr><th data-sort>Keyword</th><th data-sort>Locale</th><th data-sort>Impressions</th><th data-sort>Clicks</th><th data-sort>Position</th><th data-sort>Change</th><th data-sort>Target</th></tr></thead><tbody>
@forelse($rows as $row)
<tr>
<td><strong>{{ $row['target']->keyword }}</strong><small>{{ $row['target']->target_url ?: 'No target URL' }}</small></td>
<td>{{ strtoupper($row['target']->locale) }}</td>
<td data-value="{{ (int)($row['latest']?->impressions ?? 0) }}">{{ number_format((int)($row['latest']?->impressions ?? 0)) }}</td>
<td data-value="{{ (int)($row['latest']?->clicks ?? 0) }}">{{ number_format((int)($row['latest']?->clicks ?? 0)) }}</td>
<td data-value="{{ $row['latest']?->position ?? 999 }}">{{ $row['latest']?->position ? number_format((float)$row['latest']->position,1) : '—' }}</td>
<td data-value="{{ $row['position_delta'] ?? -999 }}">@if($row['position_delta']!==null)<span class="{{ $row['position_delta'] >= 0 ? 'status-good' : 'status-warn' }}">{{ $row['position_delta'] > 0 ? '+' : '' }}{{ number_format($row['position_delta'],1) }}</span>@else—@endif</td>
<td>#{{ number_format((float)$row['target']->target_position,1) }}</td>
</tr>
@empty<tr><td colspan="7">Add your first target keyword above.</td></tr>@endforelse
</tbody></table></div></section>

<section class="console-card table-card"><header><div><small>Quick wins</small><h2>High-impression opportunities in positions 3–25</h2></div></header>
<div class="analytics-table-wrap"><table data-datatable data-page-size="25"><thead><tr><th data-sort>Query</th><th data-sort>Clicks</th><th data-sort>Impressions</th><th data-sort>CTR</th><th data-sort>Position</th></tr></thead><tbody>
@forelse($opportunities as $metric)<tr><td><strong>{{ $metric->dimension }}</strong></td><td>{{ $metric->clicks }}</td><td>{{ $metric->impressions }}</td><td>{{ number_format((float)$metric->ctr*100,1) }}%</td><td>{{ number_format((float)$metric->position,1) }}</td></tr>@empty<tr><td colspan="5">Import Search Console data to see opportunities.</td></tr>@endforelse
</tbody></table></div></section>
@endsection
