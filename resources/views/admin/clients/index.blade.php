@extends('layouts.admin')

@section('title', 'Clients')
@section('eyebrow', 'CRM / organizations')

@section('content')
    <section class="page-heading">
        <div>
            <small class="section-code">01 / CLIENT RELATIONSHIPS</small>
            <h1>Every client, connected.</h1>
            <p>Keep organizations, contacts, delivery projects and contracts in one structured record.</p>
        </div>
        <a class="console-button console-button-primary" href="{{ route('admin.clients.create') }}">Add client <span>+</span></a>
    </section>

    <section class="console-card table-card">
        <form class="filter-bar" method="GET">
            <label class="search-field"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg><input name="search" value="{{ request('search') }}" placeholder="Search client, company or sector…"></label>
            <button class="console-button console-button-quiet" type="submit">Search</button>
        </form>
        <div class="console-table-wrap">
            <table class="console-table">
                <thead><tr><th>Client</th><th>Sector</th><th>Status</th><th>Projects</th><th>Contracts</th><th></th></tr></thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr>
                            <td><a class="lead-cell" href="{{ route('admin.clients.edit', $client) }}"><span class="lead-avatar">{{ strtoupper(substr($client->company_name ?: $client->name, 0, 1)) }}</span><span><strong>{{ $client->company_name ?: $client->name }}</strong><small>{{ $client->contact_person ?: $client->name }}</small></span></a></td>
                            <td><span class="type-label">{{ $client->sector ?: 'General' }}</span></td>
                            <td><span class="status status-{{ $client->status === 'active' ? 'published' : ($client->status === 'lead' ? 'review' : 'draft') }}">{{ $client->status }}</span></td>
                            <td>{{ $client->projects_count }}</td>
                            <td>{{ $client->contracts_count }}</td>
                            <td><a class="row-action" href="{{ route('admin.clients.edit', $client) }}">↗</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="empty-state"><i>+</i><strong>No clients yet</strong><p>Add your first client to begin linking projects and contracts.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @include('admin.partials.pagination', ['paginator' => $clients])
    </section>
@endsection
