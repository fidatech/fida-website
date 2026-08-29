@extends('layouts.admin')

@section('title', 'Opportunity pipeline')
@section('eyebrow', 'Customers / website enquiries')

@section('content')
    <section class="page-heading">
        <div><small class="section-code">01 / CUSTOMER SIGNALS</small><h1>Every enquiry. One pipeline.</h1><p>Qualify, assign and move website opportunities forward.</p></div>
        <div class="heading-stat"><small>NEW SIGNALS</small><strong>{{ \App\Models\Lead::query()->where('status', 'new')->count() }}</strong></div>
    </section>

    <section class="console-card table-card">
        <form class="filter-bar" method="GET">
            <label class="search-field"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg><input name="search" value="{{ request('search') }}" placeholder="Search name, company, email or phone…"></label>
            <select name="status"><option value="">All stages</option>@foreach(['new', 'contacted', 'qualified', 'proposal', 'won', 'lost', 'spam'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ Str::headline($status) }}</option>@endforeach</select>
            <button class="console-button console-button-quiet" type="submit">Filter</button>
        </form>
        <div class="console-table-wrap">
            <table class="console-table">
                <thead><tr><th>Opportunity</th><th>Project</th><th>Contact</th><th>Owner</th><th>Stage</th><th>Received</th><th></th></tr></thead>
                <tbody>
                    @forelse($leads as $lead)
                        <tr>
                            <td><a class="lead-cell" href="{{ route('admin.leads.show', $lead) }}"><span class="lead-avatar">{{ strtoupper(substr($lead->name, 0, 1)) }}</span><span><strong>{{ $lead->name }}</strong><small>{{ $lead->company ?: 'Independent' }}</small></span></a></td>
                            <td><span class="type-label">{{ Str::headline($lead->project_type) }}</span></td>
                            <td><span class="contact-cell"><strong>{{ $lead->email ?: $lead->phone }}</strong><small>{{ $lead->email && $lead->phone ? $lead->phone : '' }}</small></span></td>
                            <td>{{ $lead->assignee?->name ?: 'Unassigned' }}</td>
                            <td><span class="status status-{{ $lead->status }}">{{ $lead->status }}</span></td>
                            <td><time>{{ $lead->created_at->diffForHumans() }}</time></td>
                            <td><a class="row-action" href="{{ route('admin.leads.show', $lead) }}">↗</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7"><div class="empty-state"><i>◎</i><strong>No opportunities match</strong><p>New project requests from the website will appear here.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @include('admin.partials.pagination', ['paginator' => $leads])
    </section>
@endsection
