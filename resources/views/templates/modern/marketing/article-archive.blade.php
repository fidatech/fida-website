@extends('layouts.marketing')

@section('content')
@include('marketing.partials.mx-page-hero', [
    'crumbs' => [[__('website.nav.articles'), App\Support\LocalizedUrl::path('/articles')], [$title, null]],
    'eyebrow' => $taxonomyLabel,
    'title' => $title,
    'summary' => $description,
])

<section class="mx-section">
    <div class="mx-wrap">
        <header class="mx-list-head"><h2>{{ __('website.insights.published_articles') }}</h2><span>{{ $articles->count() }}</span></header>
        @if($articles->isNotEmpty())
            <div class="mx-card-grid">
                @foreach($articles as $article)
                    <a class="mx-card" href="{{ App\Support\LocalizedUrl::path('/'.$article->slug) }}">
                        <span class="mx-card-type">{{ $article->articleCategory?->translation('name') ?: __('website.page.article') }}@if($article->published_at) · <time datetime="{{ $article->published_at->toDateString() }}">{{ $article->published_at->format('Y-m-d') }}</time>@endif</span>
                        <h3>{{ $article->translation('title') }}</h3>
                        <p>{{ $article->translation('summary') }}</p>
                        @if($article->byline())<small>{{ $article->byline() }}</small>@endif
                        <b>{{ __('website.solutions.learn_more') }}</b>
                    </a>
                @endforeach
            </div>
        @else
            <div class="mx-empty"><h3>{{ __('website.hubs.empty_title') }}</h3><p>{{ __('website.hubs.empty_description') }}</p></div>
        @endif
    </div>
</section>
@endsection
