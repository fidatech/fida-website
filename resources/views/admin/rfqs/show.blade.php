@extends('layouts.admin')
@section('title',$rfq->reference)
@section('eyebrow','Procurement RFQ')
@section('content')
<div class="console-page-head">
    <div><small>{{ strtoupper($rfq->procurement_method) }} · {{ $rfq->organization_type }}</small><h1>{{ $rfq->organization_name }}</h1><p>{{ $rfq->contact_name }} · {{ $rfq->email }} @if($rfq->phone) · {{ $rfq->phone }} @endif</p></div>
    <form method="post" action="{{ route('admin.rfqs.update',$rfq) }}">@csrf @method('PUT')
        <select name="status" onchange="this.form.submit()">@foreach(['new','reviewing','qualified','quoted','closed'] as $status)<option value="{{ $status }}" @selected($rfq->status===$status)>{{ ucfirst($status) }}</option>@endforeach</select>
    </form>
</div>
<div class="console-two-column">
    <section class="console-card">
        <header class="card-head"><div><small>PROJECT REQUIREMENT</small><h2>Scope</h2></div></header>
        <div class="detail-stack">
            <div><small>Project summary</small><p>{{ $rfq->project_summary }}</p></div>
            <div><small>Technical scope</small><p style="white-space:pre-wrap">{{ $rfq->scope_requirements }}</p></div>
            @if($rfq->compliance_requirements)<div><small>Compliance / warranty / training</small><p style="white-space:pre-wrap">{{ $rfq->compliance_requirements }}</p></div>@endif
            <div><small>Capabilities</small><p>{{ implode(' · ', $rfq->capabilities ?? []) }}</p></div>
        </div>
    </section>
    <aside class="console-card">
        <header class="card-head"><div><small>PROCUREMENT DATA</small><h2>Commercial context</h2></div></header>
        <dl class="record-list">
            <div><dt>Reference</dt><dd>{{ $rfq->reference }}</dd></div>
            <div><dt>Procurement ref.</dt><dd>{{ $rfq->procurement_reference ?: '—' }}</dd></div>
            <div><dt>Deadline</dt><dd>{{ $rfq->submission_deadline?->format('d M Y') ?: '—' }}</dd></div>
            <div><dt>Budget</dt><dd>{{ $rfq->budget_currency ?: '' }} {{ $rfq->budget_min ?: '—' }} – {{ $rfq->budget_max ?: '—' }}</dd></div>
            <div><dt>Delivery</dt><dd>{{ $rfq->delivery_location ?: '—' }}</dd></div>
            <div><dt>Timeline</dt><dd>{{ $rfq->timeline ?: '—' }}</dd></div>
            <div><dt>Location</dt><dd>{{ collect([$rfq->city,$rfq->country])->filter()->implode(', ') ?: '—' }}</dd></div>
            @if($rfq->attachment_path)<div><dt>Document</dt><dd><a href="{{ route('admin.rfqs.download',$rfq) }}">{{ $rfq->attachment_name }} ↓</a></dd></div>@endif
        </dl>
    </aside>
</div>
@endsection