@extends('layouts.admin')

@php
    $activeDefinition = $activeType ? $contentTypes[$activeType] : null;
    $libraryTitle = $activeDefinition ? $activeDefinition['label'].' library' : 'Content library';
    $createLabel = $activeDefinition ? 'Create '.Str::lower($activeDefinition['singular']) : 'Create content';
@endphp

@section('title', $libraryTitle)
@section('eyebrow', 'Website / multilingual publishing')

@section('content')
    <section class="page-heading">
        <div>
            <small class="section-code">01 / {{ $activeType ? strtoupper($activeType) : 'CONTENT LIBRARY' }}</small>
            <h1>{{ $activeDefinition ? $activeDefinition['label'].' built to be found.' : 'Every story, one publishing system.' }}</h1>
            <p>{{ $activeDefinition['description'] ?? 'Manage pages, solutions, services, products, industries, case studies and articles from one multilingual library.' }}</p>
        </div>
        <a class="console-button console-button-primary" href="{{ route('admin.content-pages.create', array_filter(['type' => $activeType])) }}">{{ $createLabel }} <span>+</span></a>
    </section>

    <section class="content-type-grid" aria-label="Content types">
        <a @class(['content-type-card', 'active' => $activeType === null]) href="{{ route('admin.content-pages.index') }}">
            <span>ALL</span><strong>{{ $typeCounts->sum() }}</strong><small>All content</small>
        </a>
        @foreach($contentTypes as $type => $definition)
            <a @class(['content-type-card', 'active' => $activeType === $type]) href="{{ route('admin.content-pages.index', ['type' => $type]) }}">
                <span>{{ strtoupper(substr($type, 0, 3)) }}</span><strong>{{ $typeCounts->get($type, 0) }}</strong><small>{{ $definition['label'] }}</small>
            </a>
        @endforeach
    </section>

    <section class="console-card table-card">
        <form class="filter-bar" method="GET">
            <label class="search-field"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg><input name="search" value="{{ request('search') }}" placeholder="Search title or URL…"></label>
            <select name="type" aria-label="Content type">
                <option value="">All types</option>
                @foreach($contentTypes as $type => $definition)<option value="{{ $type }}" @selected($activeType === $type)>{{ $definition['label'] }}</option>@endforeach
            </select>
            <select name="status" aria-label="Publishing status">
                <option value="">All statuses</option><option value="published" @selected(request('status') === 'published')>Published / scheduled</option><option value="review" @selected(request('status') === 'review')>In review</option><option value="draft" @selected(request('status') === 'draft')>Draft</option>
            </select>
            <button class="console-button console-button-quiet" type="submit">Filter</button>
        </form>

        <div class="console-table-wrap">
            <table class="console-table">
                <thead><tr><th>Content</th><th>Type</th><th>Languages</th><th>Status</th><th>Updated</th><th></th></tr></thead>
                <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td><a class="table-title" href="{{ route('admin.content-pages.edit', $page) }}"><strong>{{ $page->translation('title', 'en') }}</strong><small>/{{ $page->slug }}</small></a></td>
                        <td><span class="type-label">{{ $contentTypes[$page->type]['singular'] ?? Str::headline($page->type) }}</span></td>
                        <td><span class="language-pills">@foreach(config('website.locales') as $locale => $config)<i @class(['complete' => filled($page->title[$locale] ?? null)])>{{ strtoupper($locale) }}</i>@endforeach</span></td>
                        <td><span class="status status-{{ $page->publicationStatus() }}">{{ $page->publicationStatus() }}</span></td>
                        <td><time>{{ $page->updated_at->diffForHumans() }}</time></td>
                        <td><a class="row-action" href="{{ route('admin.content-pages.edit', $page) }}" aria-label="Edit {{ $page->translation('title', 'en') }}">↗</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="empty-state"><i>+</i><strong>No content matches</strong><p>Create {{ $activeDefinition ? Str::lower($activeDefinition['singular']) : 'content' }} or adjust the current filters.</p></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @include('admin.partials.pagination', ['paginator' => $pages])
    </section>
@endsection
