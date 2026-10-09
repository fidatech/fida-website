@extends('layouts.admin')

@section('title', 'RFQ pipeline')
@section('eyebrow', 'Procurement / quotation requests')

@section('content')
<section class="page-heading">
    <div><small class="section-code">PROCUREMENT SIGNALS</small><h1>Formal RFQs in one pipeline.</h1><p>Review government, NGO and enterprise quotation requests, documents, deadlines and follow-up.</p></div>
    <div class="heading-stat"><small>NEW RFQS</small><strong>{{ AppModelsRfq::query()->where('status', 'new')->count() }}</strong></div>
</section>

<section class="console-card table-card">
    <form class="filter-bar" method="GET">
        <label class="search-field"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg><input name="search" value="{{ request('search') }}" placeholder="Search reference, organization, project or contact…"></label>
        <select name="status"><option value="">All stages</option>@foreach(['new','reviewing','clarification','qualified','quoted','submitted','won','lost','archived'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ Str::headline($status) }}</option>@endforeach</select>
        <button class="console-button console-button-quiet" type="submit">Filter</button>
    </form>
    <div class="console-table-wrap">
        <table class="console-table">
            <thead><tr><th>RFQ</th><th>Organization</th><th>Project</th><th>Deadline</th><th>Owner</th><th>Stage</th><th>Received</th><th></th></tr></thead>
            <tbody>
            @forelse($rfqs as $rfq)
                <tr>
                    <td><a href="{{ route('admin.rfqs.show', $rfq) }}"><strong>{{ $rfq->reference }}</strong></a><small style="display:block">{{ Str::headline($rfq->procurement_type) }}</small></td>
                    <td><strong>{{ $rfq->organization }}</strong><small style="display:block">{{ Str::headline($rfq->organization_type) }}</small></td>
                    <td>{{ $rfq->project_title }}</td>
                    <td>{{ $rfq->submission_deadline?->format('d M Y') ?: '—' }}</td>
                    <td>{{ $rfq->assignee?->name ?: 'Unassigned' }}</td>
                    <td><span class="status status-{{ $rfq->status }}">{{ $rfq->status }}</span></td>
                    <td><time>{{ $rfq->created_at->diffForHumans() }}</time></td>
                    <td><a class="row-action" href="{{ route('admin.rfqs.show', $rfq) }}">↗</a></td>
                </tr>
            @empty
                <tr><td colspan="8"><div class="empty-state"><i>◎</i><strong>No RFQs match</strong><p>Formal quotation requests from the website will appear here.</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @include('admin.partials.pagination', ['paginator' => $rfqs])
</section>
@endsection
