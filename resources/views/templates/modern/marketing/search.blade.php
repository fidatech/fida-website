@extends('layouts.marketing')

@section('content')
<section class="mx-page-hero">
    <div class="mx-wrap">
        <nav class="mx-crumbs" aria-label="{{ __('website.page.breadcrumbs') }}">
            <a href="{{ App\Support\LocalizedUrl::path('/') }}">{{ __('website.page.home') }}</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">{{ __('website.search.title') }}</span>
        </nav>
        <h1>{{ __('website.search.heading') }}</h1>
        <p class="mx-page-summary">{{ __('website.search.description') }}</p>
        <form class="mx-search" action="{{ App\Support\LocalizedUrl::path('/search') }}" method="get" role="search">
            <label class="mx-visually-hidden" for="site-search-query">{{ __('website.search.title') }}</label>
            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6.5"/><path d="m16 16 4.5 4.5"/></svg>
            <input id="site-search-query" name="q" type="search" value="{{ $query }}" minlength="2" maxlength="80" placeholder="{{ __('website.search.placeholder') }}" autocomplete="off">
            <button class="mx-button mx-button-primary" type="submit">{{ __('website.search.submit') }}</button>
        </form>
    </div>
</section>

<section class="mx-section">
    <div class="mx-wrap">
        @if(! $searchable)
            <div class="mx-empty"><h2>{{ __('website.search.title') }}</h2><p>{{ __('website.search.start') }}</p></div>
        @elseif($pages->isEmpty())
            <div class="mx-empty">
                <h2>{{ __('website.search.empty') }}</h2>
                <p>{{ __('website.search.empty_hint') }}</p>
                <a class="mx-button mx-button-light" href="{{ App\Support\LocalizedUrl::path('/services') }}">{{ __('website.nav.all_services') }}</a>
            </div>
        @else
            <header class="mx-list-head">
                <h2>{{ __('website.search.results', ['query' => $query]) }}</h2>
                <span>{{ __('website.search.count', ['count' => $pages->total()]) }}</span>
            </header>
            <div class="mx-card-grid">
                @foreach($pages as $resultPage)
                    <a class="mx-card" href="{{ App\Support\LocalizedUrl::path('/'.$resultPage->slug) }}">
                        <span class="mx-card-type">{{ config("website.content_types.{$resultPage->type}.singular", $resultPage->type) }}</span>
                        <h3>{{ $resultPage->translation('title') }}</h3>
                        <p>{{ $resultPage->translation('summary') }}</p>
                        <b>{{ __('website.solutions.learn_more') }}</b>
                    </a>
                @endforeach
            </div>
            @if($pages->hasPages())
                <nav class="mx-pagination" aria-label="{{ __('website.accessibility.pagination') }}">
                    @if($pages->onFirstPage())
                        <span aria-disabled="true">{{ __('website.search.previous') }}</span>
                    @else
                        <a href="{{ $pages->previousPageUrl() }}" rel="prev">{{ __('website.search.previous') }}</a>
                    @endif
                    <strong>{{ $pages->currentPage() }} / {{ $pages->lastPage() }}</strong>
                    @if($pages->hasMorePages())
                        <a href="{{ $pages->nextPageUrl() }}" rel="next">{{ __('website.search.next') }}</a>
                    @else
                        <span aria-disabled="true">{{ __('website.search.next') }}</span>
                    @endif
                </nav>
            @endif
        @endif
    </div>
</section>
@endsection
