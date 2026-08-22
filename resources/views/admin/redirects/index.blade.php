@extends('layouts.admin')

@section('title', 'Redirect manager')
@section('eyebrow', 'Website / search authority protection')

@section('content')
    <section class="page-heading">
        <div><small class="section-code">SEO / URL CONTROL</small><h1>Keep every valuable URL connected.</h1><p>Create direct permanent redirects for old pages. Slug changes made in the content editor are added here automatically in every language.</p></div>
    </section>

    <section class="console-card redirect-create-card">
        <header><small>NEW PERMANENT REDIRECT</small><span>Same-domain paths only</span></header>
        <form class="redirect-form" method="POST" action="{{ route('admin.redirects.store') }}">
            @csrf
            <label><span>Old path</span><input name="source_path" value="{{ old('source_path') }}" placeholder="/old-page" required></label>
            <b>→</b>
            <label><span>Current path</span><input name="target_path" value="{{ old('target_path') }}" placeholder="/new-page" required></label>
            <input type="hidden" name="status_code" value="301">
            <input type="hidden" name="active" value="1">
            <button class="console-button console-button-primary" type="submit">Create redirect <span>+</span></button>
        </form>
    </section>

    <section class="console-card table-card">
        <div class="console-table-wrap">
            <table class="console-table redirect-table">
                <thead><tr><th>Old URL</th><th>Destination</th><th>Code</th><th>Hits</th><th>Last used</th><th></th></tr></thead>
                <tbody>
                @forelse($redirects as $redirect)
                    <tr>
                        <td><code>{{ $redirect->source_path }}</code></td>
                        <td><code>{{ $redirect->target_path }}</code></td>
                        <td><span class="status {{ $redirect->active ? 'status-published' : 'status-draft' }}">{{ $redirect->active ? $redirect->status_code : 'OFF' }}</span></td>
                        <td>{{ number_format($redirect->hits) }}</td>
                        <td><time>{{ $redirect->last_hit_at?->diffForHumans() ?: 'Never' }}</time></td>
                        <td>
                            <form method="POST" action="{{ route('admin.redirects.destroy', $redirect) }}" onsubmit="return confirm('Remove this redirect?')">
                                @csrf @method('DELETE')
                                <button class="row-action row-action-danger" type="submit" aria-label="Delete redirect">×</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="empty-state"><i>↗</i><strong>No manual redirects yet</strong><p>They will appear here when a page slug changes or you add an old URL.</p></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @include('admin.partials.pagination', ['paginator' => $redirects])
    </section>
@endsection
