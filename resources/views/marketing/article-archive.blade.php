@extends('layouts.marketing')

@section('content')
<section class="page-hero insights-archive-hero">
    <div class="page-hero-glow"></div>
    <div class="container narrow reveal">
        <nav class="page-breadcrumbs" aria-label="{{ __('website.page.breadcrumbs') }}">
            <a href="{{ App\Support\LocalizedUrl::path('/') }}">{{ __('website.page.home') }}</a><span>/</span>
            <a href="{{ App\Support\LocalizedUrl::path('/articles') }}">{{ __('website.nav.articles') }}</a><span>/</span>
            <span aria-current="page">{{ $title }}</span>
        </nav>
        <div class="micro-label"><span>INS</span>{{ $taxonomyLabel }}</div>
        <h1>{{ $title }}</h1>
        <p>{{ $description }}</p>
    </div>
</section>

<section class="insights-list-section">
    <div class="container">
        <div class="insights-list-heading reveal"><strong>{{ __('website.insights.published_articles') }}</strong><span>{{ $articles->count() }}</span></div>
        <div class="insights-card-grid">
            @forelse($articles as $article)
                <article class="insight-card reveal">
                    <a href="{{ App\Support\LocalizedUrl::path('/'.$article->slug) }}">
                        <header><span>{{ $article->articleCategory?->translation('name') ?: __('website.page.article') }}</span>@if($article->published_at)<time datetime="{{ $article->published_at->toDateString() }}">{{ $article->published_at->format('Y-m-d') }}</time>@endif</header>
                        <h2>{{ $article->translation('title') }}</h2>
                        <p>{{ $article->translation('summary') }}</p>
                        <footer><small>{{ $article->byline() }}</small><strong>{{ __('website.solutions.learn_more') }} ↗</strong></footer>
                    </a>
                </article>
            @empty
                <div class="hub-empty-state reveal"><span>00</span><div><h3>{{ __('website.hubs.empty_title') }}</h3><p>{{ __('website.hubs.empty_description') }}</p></div></div>
            @endforelse
        </div>
    </div>
</section>
@endsection
