@extends('layouts.admin')
@section('title','Projects')
@section('eyebrow','Portfolio / delivery')
@section('content')
<section class="editor-heading"><div><small class="section-code">PROJECT LIBRARY</small><h1>Projects & screenshots</h1><p>Keep each delivered or active project connected to its client, contract, public content and visual proof.</p></div><a class="console-button console-button-primary" href="{{ route('admin.projects.create') }}">Add project ↗</a></section>
<section class="console-card table-card"><div class="admin-card-pad"><form class="inline-search" method="GET"><input name="search" value="{{ request('search') }}" placeholder="Search project or type"><button class="console-button console-button-quiet">Search</button></form></div><div class="analytics-table-wrap"><table data-datatable><thead><tr><th data-sort>Project</th><th data-sort>Client</th><th data-sort>Type</th><th data-sort>Status</th><th data-sort>Screens</th><th data-sort>Contracts</th><th></th></tr></thead><tbody>
@forelse($projects as $project)<tr><td><strong>{{ $project->name }}</strong><small>/{{ $project->slug }}</small></td><td>{{ $project->client?->company_name ?: ($project->client?->name ?: '—') }}</td><td>{{ $project->project_type ?: '—' }}</td><td>{{ strtoupper($project->status) }}</td><td>{{ $project->screenshots_count }}</td><td>{{ $project->contracts_count }}</td><td><a href="{{ route('admin.projects.edit',$project) }}">Open ↗</a></td></tr>@empty<tr><td colspan="7">No projects yet.</td></tr>@endforelse
</tbody></table></div><div class="admin-card-pad">{{ $projects->links() }}</div></section>
@endsection
