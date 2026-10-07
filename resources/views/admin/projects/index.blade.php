@extends('layouts.admin')

@section('title', 'Projects')
@section('eyebrow', 'Portfolio / delivery')

@section('content')
    <section class="page-heading">
        <div>
            <small class="section-code">01 / PROJECT LIBRARY</small>
            <h1>Delivery work, organized.</h1>
            <p>Manage active and completed projects, client relationships, contracts, public portfolio links and screenshots.</p>
        </div>
        <a class="console-button console-button-primary" href="{{ route('admin.projects.create') }}">Add project <span>+</span></a>
    </section>

    <section class="console-card table-card">
        <form class="filter-bar" method="GET">
            <label class="search-field"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg><input name="search" value="{{ request('search') }}" placeholder="Search project or type…"></label>
            <button class="console-button console-button-quiet" type="submit">Search</button>
        </form>
        <div class="console-table-wrap">
            <table class="console-table">
                <thead><tr><th>Project</th><th>Client</th><th>Type</th><th>Status</th><th>Screens</th><th>Contracts</th><th></th></tr></thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td><a class="table-title" href="{{ route('admin.projects.edit', $project) }}"><strong>{{ $project->name }}</strong><small>/{{ $project->slug }}</small></a></td>
                            <td>{{ $project->client?->company_name ?: ($project->client?->name ?: '—') }}</td>
                            <td><span class="type-label">{{ $project->project_type ?: 'General' }}</span></td>
                            <td><span class="status status-{{ $project->status === 'active' ? 'published' : ($project->status === 'completed' ? 'review' : 'draft') }}">{{ str_replace('_', ' ', $project->status) }}</span></td>
                            <td>{{ $project->screenshots_count }}</td>
                            <td>{{ $project->contracts_count }}</td>
                            <td><a class="row-action" href="{{ route('admin.projects.edit', $project) }}">↗</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7"><div class="empty-state"><i>+</i><strong>No projects yet</strong><p>Add an active or completed Fida project to build the portfolio library.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @include('admin.partials.pagination', ['paginator' => $projects])
    </section>
@endsection
