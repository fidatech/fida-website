@extends('layouts.admin')

@section('title', 'Lead · '.$lead->name)
@section('eyebrow', 'Pipeline / opportunity #'.str_pad((string) $lead->id, 4, '0', STR_PAD_LEFT))

@section('content')
    <section class="editor-heading lead-heading">
        <div><a href="{{ route('admin.leads.index') }}">← Opportunity pipeline</a><h1>{{ $lead->name }}</h1><p>{{ $lead->company ?: 'Independent enquiry' }} · received {{ $lead->created_at->diffForHumans() }}</p></div>
        <span class="status status-{{ $lead->status }} status-large">{{ $lead->status }}</span>
    </section>

    <div class="lead-layout">
        <section class="console-card lead-message">
            <header><small>01 / PROJECT REQUEST</small><span>{{ Str::headline($lead->project_type) }}</span></header>
            <blockquote>{{ $lead->message }}</blockquote>
            <div class="lead-facts">
                <div><small>Budget</small><strong>{{ $lead->budget ? Str::headline($lead->budget) : 'Not specified' }}</strong></div>
                <div><small>Language</small><strong>{{ strtoupper($lead->locale) }}</strong></div>
                <div><small>Source</small><strong>{{ $lead->utm_source ?: 'Direct' }}</strong></div>
                <div><small>Campaign</small><strong>{{ $lead->utm_campaign ?: '—' }}</strong></div>
            </div>
        </section>

        <aside class="lead-sidebar">
            <section class="console-card lead-control">
                <header><small>PIPELINE CONTROL</small></header>
                <form class="console-form" method="POST" action="{{ route('admin.leads.update', $lead) }}">
                    @csrf @method('PUT')
                    <label><span>Stage</span><select name="status">@foreach(['new', 'contacted', 'qualified', 'proposal', 'won', 'lost', 'spam'] as $status)<option value="{{ $status }}" @selected(old('status', $lead->status) === $status)>{{ Str::headline($status) }}</option>@endforeach</select></label>
                    <label><span>Owner</span><select name="assigned_to"><option value="">Unassigned</option>@foreach($assignees as $assignee)<option value="{{ $assignee->id }}" @selected((string) old('assigned_to', $lead->assigned_to) === (string) $assignee->id)>{{ $assignee->name }}</option>@endforeach</select></label>
                    <button class="console-button console-button-primary console-button-wide" type="submit">Update opportunity <span>✓</span></button>
                </form>
            </section>
            <section class="console-card contact-card">
                <header><small>CONTACT CHANNELS</small></header>
                @if($lead->email)<a href="mailto:{{ $lead->email }}"><span>@</span><div><small>Email</small><strong>{{ $lead->email }}</strong></div></a>@endif
                @if($lead->phone)<a href="tel:{{ preg_replace('/[^+0-9]/', '', $lead->phone) }}"><span>☎</span><div><small>Phone</small><strong>{{ $lead->phone }}</strong></div></a>@endif
                @if($lead->phone)<a href="https://wa.me/{{ preg_replace('/\D/', '', $lead->phone) }}" target="_blank" rel="noopener"><span>↗</span><div><small>WhatsApp</small><strong>Open conversation</strong></div></a>@endif
            </section>
            <section class="console-card source-card"><header><small>REQUEST CONTEXT</small></header><dl><dt>Interest</dt><dd>{{ $lead->interest_slug ? Str::headline($lead->interest_slug) : 'Not specified' }}</dd><dt>Page</dt><dd>{{ $lead->source_url ?: 'Unknown' }}</dd><dt>Medium</dt><dd>{{ $lead->utm_medium ?: '—' }}</dd><dt>First contacted</dt><dd>{{ $lead->contacted_at?->format('d M Y · H:i') ?: 'Not yet' }}</dd></dl></section>
        </aside>
    </div>
@endsection
