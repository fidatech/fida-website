@extends('layouts.admin')

@section('title', 'Content system')
@section('eyebrow', 'Website / multilingual publishing')

@section('content')
    <section class="page-heading">
        <div><small class="section-code">01 / CONTENT LIBRARY</small><h1>Pages built to be found.</h1><p>Manage landing pages, multilingual copy and search metadata.</p></div>
        <a class="console-button console-button-primary" href="{{ route('admin.content-pages.create') }}">Create page <span>+</span></a>
    </section>

    <section class="console-card table-card">
        <form class="filter-bar" method="GET">
            <label class="search-field"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg><input name="search" value="{{ request('search') }}" placeholder="Search title or URL…"></label>
            <select name="type" aria-label="Content type">
                <option value="">All types</option>
                @foreach(['solution', 'service', 'product', 'industry', 'case-study', 'article', 'page'] as $type)<option value="{{ $type }}" @selected(request('type') === $type)>{{ Str::headline($type) }}</option>@endforeach
            </select>
            <select name="status" aria-label="Publishing status">
                <option value="">All statuses</option><option value="published" @selected(request('status') === 'published')>Published</option><option value="draft" @selected(request('status') === 'draft')>Draft</option>
            </select>
            <button class="console-button console-button-quiet" type="submit">Filter</button>
        </form>

        <div class="console-table-wrap">
            <table class="console-table">
                <thead><tr><th>Page</th><th>Type</th><th>Languages</th><th>Status</th><th>Updated</th><th></th></tr></thead>
                <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td><a class="table-title" href="{{ route('admin.content-pages.edit', $page) }}"><strong>{{ $page->translation('title', 'en') }}</strong><small>/{{ $page->slug }}</small></a></td>
                        <td><span class="type-label">{{ Str::headline($page->type) }}</span></td>
                        <td><span class="language-pills">@foreach(config('website.locales') as $locale => $config)<i @class(['complete' => filled($page->title[$locale] ?? null)])>{{ strtoupper($locale) }}</i>@endforeach</span></td>
                        <td><span class="status status-{{ $page->status }}">{{ $page->status }}</span></td>
                        <td><time>{{ $page->updated_at->diffForHumans() }}</time></td>
                        <td><a class="row-action" href="{{ route('admin.content-pages.edit', $page) }}" aria-label="Edit {{ $page->translation('title', 'en') }}">↗</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="empty-state"><i>+</i><strong>No content matches</strong><p>Create a page or adjust the current filters.</p></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @include('admin.partials.pagination', ['paginator' => $pages])
    </section>
@endsection
