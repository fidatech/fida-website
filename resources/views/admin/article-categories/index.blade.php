@extends('layouts.admin')

@section('title', 'Insight categories')
@section('eyebrow', 'Insights / topic architecture')

@section('content')
    <section class="page-heading"><div><small class="section-code">INS / CATEGORIES</small><h1>Organize useful answers by topic.</h1><p>Manage multilingual category archives, metadata and publishing visibility.</p></div><a class="console-button console-button-primary" href="{{ route('admin.article-categories.create') }}">Create category <span>+</span></a></section>
    <section class="console-card table-card">
        <div class="console-table-wrap"><table class="console-table"><thead><tr><th>Category</th><th>URL</th><th>Articles</th><th>Status</th><th></th></tr></thead><tbody>
            @forelse($categories as $category)
                <tr><td><a class="table-title" href="{{ route('admin.article-categories.edit', $category) }}"><strong>{{ $category->translation('name', 'en') }}</strong><small>{{ $category->translation('description', 'en') }}</small></a></td><td>/articles/category/{{ $category->slug }}</td><td>{{ $category->articles_count }}</td><td><span class="status status-{{ $category->active ? 'published' : 'draft' }}">{{ $category->active ? 'active' : 'inactive' }}</span></td><td><a class="row-action" href="{{ route('admin.article-categories.edit', $category) }}">↗</a></td></tr>
            @empty
                <tr><td colspan="5"><div class="empty-state"><i>+</i><strong>No insight categories</strong><p>Create a multilingual topic before assigning it to articles.</p></div></td></tr>
            @endforelse
        </tbody></table></div>
    </section>
@endsection
