@extends('layouts.admin')
@section('title','Clients')
@section('eyebrow','CRM / organizations')
@section('content')
<section class="editor-heading"><div><small class="section-code">CLIENT RELATIONSHIPS</small><h1>Clients</h1><p>Keep client identity, contacts, projects and contracts connected in one place.</p></div><a class="console-button console-button-primary" href="{{ route('admin.clients.create') }}">Add client ↗</a></section>
<section class="console-card table-card"><div class="admin-card-pad"><form class="inline-search" method="GET"><input name="search" value="{{ request('search') }}" placeholder="Search client, company or sector"><button class="console-button console-button-quiet">Search</button></form></div><div class="analytics-table-wrap"><table data-datatable><thead><tr><th data-sort>Client</th><th data-sort>Sector</th><th data-sort>Status</th><th data-sort>Projects</th><th data-sort>Contracts</th><th></th></tr></thead><tbody>
@forelse($clients as $client)<tr><td><strong>{{ $client->company_name ?: $client->name }}</strong><small>{{ $client->contact_person ?: $client->name }}</small></td><td>{{ $client->sector ?: '—' }}</td><td>{{ strtoupper($client->status) }}</td><td>{{ $client->projects_count }}</td><td>{{ $client->contracts_count }}</td><td><a href="{{ route('admin.clients.edit',$client) }}">Open ↗</a></td></tr>@empty<tr><td colspan="6">No clients yet.</td></tr>@endforelse
</tbody></table></div><div class="admin-card-pad">{{ $clients->links() }}</div></section>
@endsection
