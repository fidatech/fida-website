@extends('layouts.marketing')

@section('content')
<section class="page-hero search-page-hero">
    <div class="page-hero-glow"></div>
    <div class="container narrow reveal">
        <nav class="page-breadcrumbs" aria-label="{{ __('website.page.breadcrumbs') }}">
            <a href="{{ App\Support\LocalizedUrl::path('/') }}">{{ __('website.page.home') }}</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">{{ __('website.search.title') }}</span>
        </nav>
        <div class="micro-label"><span>01</span>{{ __('website.search.eyebrow') }}</div>
        <h1>{{ __('website.search.heading') }}</h1>
        <p>{{ __('website.search.description') }}</p>

        <form class="site-search-form" action="{{ App\Support\LocalizedUrl::path('/search') }}" method="get" role="search">
            <label class="sr-only" for="site-search-query">{{ __('website.search.title') }}</label>
            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6"/><path d="m16 16 4 4"/></svg>
            <input id="site-search-query" name="q" type="search" value="{{ $query }}" minlength="2" maxlength="80" placeholder="{{ __('website.search.placeholder') }}" autocomplete="off">
            <button class="button button-lime" type="submit">{{ __('website.search.submit') }} <span class="button-arrow">↗</span></button>
        </form>
    </div>
</section>

<section class="search-results-section">
    <div class="container">
        @if(! $searchable)
            <div class="search-empty-state reveal">
                <span>⌕</span>
                <div><h2>{{ __('website.search.title') }}</h2><p>{{ __('website.search.start') }}</p></div>
            </div>
        @elseif($pages->isEmpty())
            <div class="search-empty-state reveal">
                <span>00</span>
                <div><h2>{{ __('website.search.empty') }}</h2><p>{{ __('website.search.empty_hint') }}</p></div>
                <a class="button button-wire" href="{{ App\Support\LocalizedUrl::path('/services') }}">{{ __('website.nav.all_services') }} <span class="button-arrow">↗</span></a>
            </div>
        @else
            <header class="search-results-heading reveal">
                <div>
                    <div class="micro-label"><span>02</span>{{ __('website.search.title') }}</div>
                    <h2>{{ __('website.search.results', ['query' => $query]) }}</h2>
                </div>
                <strong>{{ __('website.search.count', ['count' => $pages->total()]) }}</strong>
            </header>

            <div class="search-results-grid">
                @foreach($pages as $resultPage)
                    <a class="search-result-card reveal" href="{{ App\Support\LocalizedUrl::path('/'.$resultPage->slug) }}">
                        <header><span>{{ str_pad((string) ($pages->firstItem() + $loop->index), 2, '0', STR_PAD_LEFT) }}</span><b>{{ strtoupper(config("website.content_types.{$resultPage->type}.singular", $resultPage->type)) }}</b><i>↗</i></header>
                        <h3>{{ $resultPage->translation('title') }}</h3>
                        <p>{{ $resultPage->translation('summary') }}</p>
                    </a>
                @endforeach
            </div>

            @if($pages->hasPages())
                <nav class="search-pagination" aria-label="Pagination">
                    @if($pages->onFirstPage())
                        <span aria-disabled="true">← {{ __('website.search.previous') }}</span>
                    @else
                        <a href="{{ $pages->previousPageUrl() }}" rel="prev">← {{ __('website.search.previous') }}</a>
                    @endif
                    <strong>{{ $pages->currentPage() }} / {{ $pages->lastPage() }}</strong>
                    @if($pages->hasMorePages())
                        <a href="{{ $pages->nextPageUrl() }}" rel="next">{{ __('website.search.next') }} →</a>
                    @else
                        <span aria-disabled="true">{{ __('website.search.next') }} →</span>
                    @endif
                </nav>
            @endif
        @endif
    </div>
</section>
@endsection
