@extends('layouts.marketing')

@php use App\Support\LocalizedUrl; use App\Support\ModernNav; @endphp

@section('content')
@include('marketing.partials.mx-page-hero', [
    'crumbs' => [[$page->translation('title'), null]],
    'eyebrow' => $page->translation('eyebrow'),
    'title' => $page->translation('title'),
    'summary' => $page->translation('summary'),
    'actions' => ! in_array($hubLayout, ['contact', 'articles'], true),
    'interest' => $page->slug,
])

@if($hubLayout === 'about')
<section class="mx-section mx-section-tight">
    <div class="mx-wrap">
        <dl class="mx-fact-grid">
            @foreach(__('website.company.facts') as $fact)
                <div><dt>{{ $fact['label'] }}</dt><dd>{{ $fact['value'] }}</dd></div>
            @endforeach
        </dl>
    </div>
</section>
@endif

@if(config("website.content_hubs.{$hubLayout}"))
<section class="mx-section">
    <div class="mx-wrap">
        <header class="mx-section-head">
            <h2>{{ __("website.hubs.{$hubLayout}.title") }}</h2>
            <p>{{ __("website.hubs.{$hubLayout}.description") }}</p>
        </header>
        @if($hubLayout === 'articles' && $articleCategories->isNotEmpty())
            <nav class="mx-topic-nav" aria-label="{{ __('website.insights.categories') }}">
                <span>{{ __('website.insights.explore_topics') }}</span>
                <ul class="mx-chips">
                    @foreach($articleCategories as $articleCategory)
                        <li><a href="{{ LocalizedUrl::path('/articles/category/'.$articleCategory->slug) }}">{{ $articleCategory->translation('name') }} <small>{{ $articleCategory->articles_count }}</small></a></li>
                    @endforeach
                </ul>
            </nav>
        @endif
        @if($collectionPages->isNotEmpty())
            <div class="mx-card-grid">
                @foreach($collectionPages as $collectionPage)
                    <a class="mx-card" href="{{ LocalizedUrl::path('/'.$collectionPage->slug) }}">
                        <span class="mx-card-icon" aria-hidden="true">{{ mb_strtoupper(mb_substr(ModernNav::label($collectionPage->translation('title')), 0, 1)) }}</span>
                        <h3>{{ $hubLayout === 'articles' ? $collectionPage->translation('title') : ModernNav::label($collectionPage->translation('title')) }}</h3>
                        <p>{{ $collectionPage->translation('summary') }}</p>
                        @if($hubLayout === 'articles' && ($collectionPage->articleCategory || $collectionPage->byline()))
                            <small>{{ $collectionPage->articleCategory?->translation('name') }}@if($collectionPage->articleCategory && $collectionPage->byline()), @endif{{ $collectionPage->byline() }}</small>
                        @endif
                        <b>{{ __('website.solutions.learn_more') }}</b>
                    </a>
                @endforeach
            </div>
        @else
            <div class="mx-empty">
                <h3>{{ __('website.hubs.empty_title') }}</h3>
                <p>{{ __('website.hubs.empty_description') }}</p>
                <a class="mx-button mx-button-light" href="{{ LocalizedUrl::path('/contact') }}">{{ __('website.page.cta') }}</a>
            </div>
        @endif
    </div>
</section>
@endif

@if($hubLayout === 'products' && filled($portfolioBody))
<section class="mx-section mx-section-soft" aria-label="{{ $page->translation('title') }}">
    <div class="mx-wrap">
        <header class="mx-section-head">
            <h2>{{ __('website.products_catalog.title') }}</h2>
            <p>{{ __('website.products_catalog.description') }}</p>
        </header>
        <article class="mx-prose mx-portfolio">{!! $portfolioBody !!}</article>
    </div>
</section>
@endif

@if($hubLayout === 'pricing')
<section class="mx-section">
    <div class="mx-wrap">
        <header class="mx-section-head">
            <h2>{{ __('website.pricing.title') }}</h2>
            <p>{{ __('website.pricing.description') }}</p>
        </header>
        <div class="mx-pricing">
            @foreach(__('website.pricing.paths') as $path)
                <article @class(['mx-plan', 'mx-plan-featured' => $loop->iteration === 2])>
                    <small>{{ $path['label'] }}</small>
                    <h3>{{ $path['title'] }}</h3>
                    <p>{{ $path['description'] }}</p>
                    <strong>{{ __('website.pricing.quote') }}</strong>
                    <ul>@foreach($path['includes'] as $item)<li>{{ $item }}</li>@endforeach</ul>
                    <a class="mx-button {{ $loop->iteration === 2 ? 'mx-button-primary' : 'mx-button-light' }}" href="{{ LocalizedUrl::path('/contact') }}#contact" data-track-event="pricing_cta" data-track-label="{{ $loop->iteration }}">{{ __('website.pricing.cta') }}</a>
                </article>
            @endforeach
        </div>
        <p class="mx-note">{{ __('website.pricing.note') }}</p>
    </div>
</section>
@endif

@if($hubLayout !== 'contact')
<section class="mx-section mx-content-section">
    <div class="mx-wrap mx-content-layout">
        <article class="mx-prose">
            @if($hubLayout === 'projects')
                {!! $projectBody !!}
                <p><a href="{{ LocalizedUrl::path('/products') }}">{{ __('website.nav.all_products') }}</a></p>
            @else
                {!! $page->translation('body') !!}
            @endif
        </article>
        @include('marketing.partials.mx-cta-card', [
            'heading' => __('website.page.cta_title'),
            'description' => __('website.page.cta_description'),
            'primaryUrl' => LocalizedUrl::path('/contact').'#contact',
            'primaryLabel' => __('website.page.cta'),
            'secondaryUrl' => LocalizedUrl::path('/request-for-quotation'),
            'secondaryLabel' => __('modern.nav.rfq'),
            'trackLabel' => $page->slug,
        ])
    </div>
</section>
@endif

@if($hubLayout === 'contact')
    @include('marketing.templates.modern.partials.contact', ['page' => $page])
@endif

@include('marketing.partials.mx-faq', ['faqs' => $faqs])
@endsection
