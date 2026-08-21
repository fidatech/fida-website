@extends('layouts.admin')

@section('title', 'Team & roles')
@section('eyebrow', 'Control / administrator access')

@section('content')
    <section class="page-heading"><div><small class="section-code">01 / ACCESS CONTROL</small><h1>The right access. Nothing more.</h1><p>Manage website administrators with focused content and sales roles.</p></div><a class="console-button console-button-primary" href="{{ route('admin.users.create') }}">Add team member <span>+</span></a></section>
    <section class="console-card table-card">
        <div class="console-table-wrap">
            <table class="console-table"><thead><tr><th>Team member</th><th>Role</th><th>Access</th><th>Last login</th><th>Status</th><th></th></tr></thead><tbody>
                @foreach($users as $user)
                    <tr><td><a class="lead-cell" href="{{ route('admin.users.edit', $user) }}"><span class="lead-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</span><span><strong>{{ $user->name }}</strong><small>{{ $user->email }}</small></span></a></td><td><span class="type-label">{{ $user->roleLabel() }}</span></td><td><span class="permission-copy">{{ match($user->role) {'super_admin' => 'All console areas', 'editor' => 'Content and SEO', 'sales' => 'Leads and pipeline', default => 'None'} }}</span></td><td>{{ $user->last_login_at?->diffForHumans() ?: 'Never' }}</td><td><span class="status {{ $user->active ? 'status-published' : 'status-lost' }}">{{ $user->active ? 'active' : 'disabled' }}</span></td><td><a class="row-action" href="{{ route('admin.users.edit', $user) }}">↗</a></td></tr>
                @endforeach
            </tbody></table>
        </div>
        @include('admin.partials.pagination', ['paginator' => $users])
    </section>
@endsection
