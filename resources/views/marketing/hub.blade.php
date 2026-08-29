@extends('layouts.marketing')

@section('content')
<section class="page-hero hub-page-hero hub-page-hero-{{ $hubLayout }}">
    <div class="page-hero-glow"></div>
    <div class="container narrow reveal">
        <nav class="page-breadcrumbs" aria-label="{{ __('website.page.breadcrumbs') }}">
            <a href="{{ App\Support\LocalizedUrl::path('/') }}">{{ __('website.page.home') }}</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">{{ $page->translation('title') }}</span>
        </nav>
        <div class="micro-label"><span>FIDA / {{ strtoupper(substr($hubLayout, 0, 3)) }}</span>{{ $page->translation('eyebrow') }}</div>
        <h1>{{ $page->translation('title') }}</h1>
        <p>{{ $page->translation('summary') }}</p>
    </div>
</section>

@if($hubLayout === 'about')
<section class="hub-proof-section">
    <div class="container hub-proof-grid reveal">
        @foreach(__('website.company.facts') as $fact)
            <article><span>0{{ $loop->iteration }}</span><small>{{ $fact['label'] }}</small><strong>{{ $fact['value'] }}</strong></article>
        @endforeach
    </div>
</section>
@endif

@if(config("website.content_hubs.{$hubLayout}"))
<section class="hub-collection-section">
    <div class="container">
        <div class="hub-section-heading reveal">
            <div class="micro-label"><span>01</span>{{ __("website.hubs.{$hubLayout}.eyebrow") }}</div>
            <h2>{{ __("website.hubs.{$hubLayout}.title") }}</h2>
            <p>{{ __("website.hubs.{$hubLayout}.description") }}</p>
        </div>
        @if($hubLayout === 'articles' && $articleCategories->isNotEmpty())
            <nav class="insights-category-nav reveal" aria-label="{{ __('website.insights.categories') }}">
                <span>{{ __('website.insights.explore_topics') }}</span>
                @foreach($articleCategories as $articleCategory)
                    <a href="{{ App\Support\LocalizedUrl::path('/articles/category/'.$articleCategory->slug) }}">{{ $articleCategory->translation('name') }} <small>{{ $articleCategory->articles_count }}</small></a>
                @endforeach
            </nav>
        @endif
        @if($collectionPages->isNotEmpty())
            <div class="hub-card-grid hub-card-grid-{{ $hubLayout }}">
                @foreach($collectionPages as $collectionPage)
                    <a class="hub-card reveal" data-tilt href="{{ App\Support\LocalizedUrl::path('/'.$collectionPage->slug) }}">
                        <div class="hub-card-gridline" aria-hidden="true"></div>
                        <header><span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><b>{{ strtoupper(config("website.content_types.{$collectionPage->type}.singular", Str::headline($collectionPage->type))) }}</b><i>↗</i></header>
                        <div class="hub-card-core" aria-hidden="true"><span>{{ strtoupper(substr($collectionPage->slug, 0, 2)) }}</span><i></i><i></i></div>
                        <div><h3>{{ $collectionPage->translation('title') }}</h3><p>{{ $collectionPage->translation('summary') }}</p><strong>{{ __('website.solutions.learn_more') }} ↗</strong></div>
                        @if($hubLayout === 'articles' && ($collectionPage->articleCategory || $collectionPage->byline()))
                            <footer class="hub-card-editorial"><span>{{ $collectionPage->articleCategory?->translation('name') }}</span><small>{{ $collectionPage->byline() }}</small></footer>
                        @endif
                    </a>
                @endforeach
            </div>
        @else
            <div class="hub-empty-state reveal">
                <span>00</span>
                <div><h3>{{ __('website.hubs.empty_title') }}</h3><p>{{ __('website.hubs.empty_description') }}</p></div>
                <a class="button button-wire" href="{{ App\Support\LocalizedUrl::path('/contact') }}">{{ __('website.page.cta') }} <span class="button-arrow">↗</span></a>
            </div>
        @endif
    </div>
</section>
@endif

@if($hubLayout === 'pricing')
<section class="hub-pricing-section">
    <div class="container">
        <div class="hub-section-heading reveal">
            <div class="micro-label"><span>01</span>{{ __('website.pricing.eyebrow') }}</div>
            <h2>{{ __('website.pricing.title') }}</h2>
            <p>{{ __('website.pricing.description') }}</p>
        </div>
        <div class="pricing-grid">
            @foreach(__('website.pricing.paths') as $path)
                <article @class(['pricing-card', 'pricing-card-featured' => $loop->iteration === 2, 'reveal'])>
                    <header><span>0{{ $loop->iteration }}</span><small>{{ $path['label'] }}</small></header>
                    <h3>{{ $path['title'] }}</h3>
                    <p>{{ $path['description'] }}</p>
                    <strong>{{ __('website.pricing.quote') }}</strong>
                    <ul>@foreach($path['includes'] as $item)<li>{{ $item }}</li>@endforeach</ul>
                    <a class="button {{ $loop->iteration === 2 ? 'button-lime' : 'button-wire' }}" href="{{ App\Support\LocalizedUrl::path('/contact') }}" data-track-event="pricing_cta" data-track-label="{{ $loop->iteration }}">{{ __('website.pricing.cta') }} <span class="button-arrow">↗</span></a>
                </article>
            @endforeach
        </div>
        <p class="pricing-note reveal">{{ __('website.pricing.note') }}</p>
    </div>
</section>
@endif

@if($hubLayout !== 'contact')
<section class="page-content-section hub-content-section">
    <div class="container content-layout">
        <article class="prose reveal">{!! $page->translation('body') !!}</article>
        <aside class="page-cta reveal">
            <span>{{ config('website.name') }}</span>
            <h2>{{ __('website.page.cta_title') }}</h2>
            <p>{{ __('website.page.cta_description') }}</p>
            <a class="button button-lime" href="{{ App\Support\LocalizedUrl::path('/contact') }}" data-track-event="cta_click" data-track-label="{{ $page->slug }}">{{ __('website.page.cta') }} <span class="button-arrow">↗</span></a>
        </aside>
    </div>
</section>
@endif

@if($hubLayout === 'contact')
    @include('marketing.partials.contact-section')
@endif

@if($faqs !== [])
<section class="page-faq-section" id="frequently-asked-questions">
    <div class="container page-section-grid">
        <div class="page-section-intro reveal">
            <div class="micro-label"><span>02</span>{{ __('website.page.faq_eyebrow') }}</div>
            <h2>{{ __('website.page.faq_title') }}</h2>
            <p>{{ __('website.page.faq_description') }}</p>
        </div>
        <div class="faq-list reveal">
            @foreach($faqs as $faq)
                <details class="faq-item" lang="{{ $faq['locale'] }}" dir="{{ config("website.locales.{$faq['locale']}.direction", 'ltr') }}" @if($loop->first) open @endif>
                    <summary><span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>{{ $faq['question'] }}<i aria-hidden="true">+</i></summary>
                    <p>{{ $faq['answer'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
