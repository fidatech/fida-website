@extends('layouts.admin')

@section('title', $rfq->reference)
@section('eyebrow', 'Procurement / '.$rfq->reference)

@section('content')
<section class="editor-heading lead-heading">
    <div><a href="{{ route('admin.rfqs.index') }}">← RFQ pipeline</a><h1>{{ $rfq->project_title }}</h1><p>{{ $rfq->organization }} · received {{ $rfq->created_at->diffForHumans() }}</p></div>
    <span class="status status-{{ $rfq->status }} status-large">{{ $rfq->status }}</span>
</section>

<div class="lead-layout">
    <section class="console-card lead-message">
        <header><small>PROCUREMENT REQUEST</small><span>{{ Str::headline($rfq->procurement_type) }}</span></header>
        <blockquote>{{ $rfq->requirements }}</blockquote>
        <div class="lead-facts">
            <div><small>Organization</small><strong>{{ $rfq->organization }}</strong></div>
            <div><small>Type</small><strong>{{ Str::headline($rfq->organization_type) }}</strong></div>
            <div><small>Deadline</small><strong>{{ $rfq->submission_deadline?->format('d M Y') ?: 'Not specified' }}</strong></div>
            <div><small>Location</small><strong>{{ $rfq->location ?: 'Not specified' }}</strong></div>
            <div><small>Budget</small><strong>{{ $rfq->budget ?: 'Not disclosed' }}</strong></div>
            <div><small>Language</small><strong>{{ strtoupper($rfq->locale) }}</strong></div>
        </div>

        @if(!empty($rfq->attachments))
            <div class="rfq-attachments">
                <h3>Submitted documents</h3>
                @foreach($rfq->attachments as $index => $file)
                    <a class="console-button console-button-quiet" href="{{ route('admin.rfqs.attachments.show', [$rfq, $index]) }}">
                        {{ $file['name'] }} <span>↓</span>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    <aside class="lead-sidebar">
        <section class="console-card lead-control">
            <header><small>RFQ CONTROL</small></header>
            <form class="console-form" method="POST" action="{{ route('admin.rfqs.update', $rfq) }}">
                @csrf @method('PUT')
                <label><span>Stage</span><select name="status">@foreach(['new','reviewing','clarification','qualified','quoted','submitted','won','lost','archived'] as $status)<option value="{{ $status }}" @selected(old('status', $rfq->status) === $status)>{{ Str::headline($status) }}</option>@endforeach</select></label>
                <label><span>Owner</span><select name="assigned_to"><option value="">Unassigned</option>@foreach($assignees as $assignee)<option value="{{ $assignee->id }}" @selected((string) old('assigned_to', $rfq->assigned_to) === (string) $assignee->id)>{{ $assignee->name }}</option>@endforeach</select></label>
                <label><span>Internal notes</span><textarea name="internal_notes" rows="7">{{ old('internal_notes', $rfq->internal_notes) }}</textarea></label>
                <button class="console-button console-button-primary console-button-wide" type="submit">Update RFQ <span>✓</span></button>
            </form>
        </section>

        <section class="console-card contact-card">
            <header><small>PROCUREMENT CONTACT</small></header>
            <a href="mailto:{{ $rfq->email }}"><span>@</span><div><small>Email</small><strong>{{ $rfq->email }}</strong></div></a>
            @if($rfq->phone)<a href="tel:{{ preg_replace('/[^+0-9]/', '', $rfq->phone) }}"><span>☎</span><div><small>Phone</small><strong>{{ $rfq->phone }}</strong></div></a>@endif
            @if($rfq->phone)<a href="https://wa.me/{{ preg_replace('/D/', '', $rfq->phone) }}" target="_blank" rel="noopener"><span>↗</span><div><small>WhatsApp</small><strong>Open conversation</strong></div></a>@endif
        </section>

        <section class="console-card source-card">
            <header><small>REQUEST CONTEXT</small></header>
            <dl>
                <dt>Contact</dt><dd>{{ $rfq->contact_name }}@if($rfq->job_title) · {{ $rfq->job_title }}@endif</dd>
                <dt>Source page</dt><dd>{{ $rfq->source_url ?: 'Unknown' }}</dd>
                <dt>Reviewed</dt><dd>{{ $rfq->reviewed_at?->format('d M Y · H:i') ?: 'Not yet' }}</dd>
            </dl>
        </section>
    </aside>
</div>
@endsection
