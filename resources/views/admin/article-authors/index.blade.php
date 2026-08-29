@extends('layouts.admin')

@section('title', 'Insight authors')
@section('eyebrow', 'Insights / verified bylines')

@section('content')
    <section class="page-heading"><div><small class="section-code">INS / AUTHORS</small><h1>Manage visible editorial responsibility.</h1><p>Keep author names, roles and multilingual biographies consistent across articles and schema.</p></div><a class="console-button console-button-primary" href="{{ route('admin.article-authors.create') }}">Create author <span>+</span></a></section>
    <section class="console-card table-card"><div class="console-table-wrap"><table class="console-table"><thead><tr><th>Author</th><th>Role</th><th>Articles</th><th>Status</th><th></th></tr></thead><tbody>
        @forelse($authors as $author)
            <tr><td><a class="table-title" href="{{ route('admin.article-authors.edit', $author) }}"><strong>{{ $author->name }}</strong><small>/articles/author/{{ $author->slug }}</small></a></td><td>{{ $author->translation('role', 'en') ?: '—' }}</td><td>{{ $author->articles_count }}</td><td><span class="status status-{{ $author->active ? 'published' : 'draft' }}">{{ $author->active ? 'active' : 'inactive' }}</span></td><td><a class="row-action" href="{{ route('admin.article-authors.edit', $author) }}">↗</a></td></tr>
        @empty
            <tr><td colspan="5"><div class="empty-state"><i>+</i><strong>No insight authors</strong><p>Create a verified author record before assigning a public byline.</p></div></td></tr>
        @endforelse
    </tbody></table></div></section>
@endsection
