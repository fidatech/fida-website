@extends('layouts.admin')

@section('title', 'Case studies')
@section('eyebrow', 'Growth / proof & authority')

@section('content')
    <section class="page-heading">
        <div>
            <small class="section-code">01 / IMPLEMENTATION EVIDENCE</small>
            <h1>Turn delivery work into proof.</h1>
            <p>Create a case study manually or use the guided interview to prepare a multilingual draft from verified project facts.</p>
        </div>
        <div class="editor-actions">
            <a class="console-button console-button-quiet" href="{{ route('admin.content-pages.create', ['type' => 'case-study']) }}">Manual case study</a>
            <a class="console-button console-button-primary" href="{{ route('admin.case-studies.create') }}">Guided draft <span>✦</span></a>
        </div>
    </section>

    <section class="console-card table-card">
        <div class="console-table-wrap">
            <table class="console-table">
                <thead><tr><th>Case study</th><th>Languages</th><th>Status</th><th>Updated</th><th></th></tr></thead>
                <tbody>
                    @forelse($caseStudies as $page)
                        <tr>
                            <td><a class="table-title" href="{{ route('admin.content-pages.edit', $page) }}"><strong>{{ $page->translation('title', 'en') }}</strong><small>/{{ $page->slug }}</small></a></td>
                            <td><span class="language-pills">@foreach(config('website.locales') as $locale => $config)<i @class(['complete' => filled($page->title[$locale] ?? null)])>{{ strtoupper($locale) }}</i>@endforeach</span></td>
                            <td><span class="status status-{{ $page->publicationStatus() }}">{{ $page->publicationStatus() }}</span></td>
                            <td><time>{{ $page->updated_at->diffForHumans() }}</time></td>
                            <td><a class="row-action" href="{{ route('admin.content-pages.edit', $page) }}">↗</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><div class="empty-state"><i>◎</i><strong>No case studies yet</strong><p>Create one manually or start with the guided interview.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @include('admin.partials.pagination', ['paginator' => $caseStudies])
    </section>
@endsection
