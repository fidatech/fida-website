@extends('layouts.admin')

@section('title', 'Command center')
@section('eyebrow', 'Overview / live operations')

@section('content')
    <section class="dashboard-intro">
        <div>
            <small class="section-code">01 / SYSTEM OVERVIEW</small>
            <h1>Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ explode(' ', auth()->user()->name)[0] }}.</h1>
            <p>Your website, content and incoming opportunities are ready.</p>
        </div>
        <span class="dashboard-date">{{ now()->format('D · d M Y') }}<i></i>{{ now()->format('H:i') }} AFT</span>
    </section>

    <section class="metric-grid">
        <article class="metric-card metric-lime">
            <div><small>Published pages</small><strong>{{ $publishedCount }}</strong></div>
            <span class="metric-icon"><svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm0 0c2.5 2.7 3.8 6 3.8 10S14.5 19.3 12 22m0-20C9.5 4.7 8.2 8 8.2 12s1.3 7.3 3.8 10M2 12h20"/></svg></span>
            <div class="metric-track"><i style="width: {{ $pageCount ? min(100, ($publishedCount / $pageCount) * 100) : 0 }}%"></i></div>
            <p>{{ $pageCount - $publishedCount }} draft {{ Str::plural('page', $pageCount - $publishedCount) }}</p>
        </article>
        @if(auth()->user()->allows('leads.manage'))
            <article class="metric-card metric-violet">
                <div><small>Total opportunities</small><strong>{{ $leadCount }}</strong></div>
                <span class="metric-icon"><svg viewBox="0 0 24 24"><path d="M4 5h16v14H4V5Zm0 3 8 5 8-5"/></svg></span>
                <div class="metric-track"><i style="width: {{ $leadCount ? min(100, ($newLeadCount / $leadCount) * 100) : 0 }}%"></i></div>
                <p><b>{{ $newLeadCount }}</b> awaiting first response</p>
            </article>
        @endif
        <article class="metric-card metric-cyan">
            <div><small>Language coverage</small><strong>03</strong></div>
            <span class="metric-icon"><svg viewBox="0 0 24 24"><path d="M4 5h10M9 3v2m1 0c0 5-3 8-6 9m3-5c2 3 4 4 7 5m2-5 4 11m-2-5h4"/></svg></span>
            <div class="metric-track"><i style="width:100%"></i></div>
            <p>English · Dari · Pashto</p>
        </article>
        <article class="metric-card metric-orange">
            <div><small>Platform health</small><strong>99.9</strong></div>
            <span class="metric-icon"><svg viewBox="0 0 24 24"><path d="M3 12h4l2-6 4 12 2-6h6"/></svg></span>
            <div class="metric-track"><i style="width:99.9%"></i></div>
            <p><span class="online-dot"></span> Application operational</p>
        </article>
    </section>

    <section class="dashboard-columns">
        <article class="console-card activity-card">
            <header>
                <div><small>02 / PIPELINE</small><h2>Latest opportunities</h2></div>
                @if(auth()->user()->allows('leads.manage'))<a href="{{ route('admin.leads.index') }}">View all ↗</a>@endif
            </header>
            @if(auth()->user()->allows('leads.manage'))
                <div class="activity-list">
                    @forelse($latestLeads as $lead)
                        <a href="{{ route('admin.leads.show', $lead) }}">
                            <span class="lead-avatar">{{ strtoupper(substr($lead->name, 0, 1)) }}</span>
                            <span><strong>{{ $lead->name }}</strong><small>{{ $lead->company ?: $lead->email ?: $lead->phone }}</small></span>
                            <b class="status status-{{ $lead->status }}">{{ $lead->status }}</b>
                            <time>{{ $lead->created_at->diffForHumans(short: true) }}</time>
                        </a>
                    @empty
                        <div class="empty-state"><i>+</i><strong>No opportunities yet</strong><p>New website enquiries will appear here.</p></div>
                    @endforelse
                </div>
            @else
                <div class="empty-state"><i>F</i><strong>Content workspace ready</strong><p>Use the content area to update pages and search metadata.</p></div>
            @endif
        </article>

        <article class="console-card quick-card">
            <header><div><small>03 / ACTIONS</small><h2>Quick launch</h2></div></header>
            <div class="quick-grid">
                @if(auth()->user()->allows('content.manage'))
                    <a href="{{ route('admin.content-pages.create') }}"><span>+</span><strong>New page</strong><small>Create multilingual content</small></a>
                    <a href="{{ route('admin.content-pages.index') }}"><span>↗</span><strong>SEO content</strong><small>Titles and descriptions</small></a>
                @endif
                @if(auth()->user()->allows('leads.manage'))
                    <a href="{{ route('admin.leads.index', ['status' => 'new']) }}"><span>◎</span><strong>New leads</strong><small>Continue the pipeline</small></a>
                @endif
                <a href="{{ route('home') }}" target="_blank"><span>⌁</span><strong>Live website</strong><small>Open public experience</small></a>
            </div>
        </article>
    </section>
@endsection
