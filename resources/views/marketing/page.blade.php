@extends('layouts.marketing')

@section('content')
<section @class(['page-hero', 'product-page-hero' => $productProfile]) @if($productProfile) style="--product-accent: {{ $productProfile['accent'] }}" @endif>
    <div class="page-hero-glow"></div>
    <div class="container narrow reveal">
        <nav class="page-breadcrumbs" aria-label="{{ __('website.page.breadcrumbs') }}">
            <a href="{{ App\Support\LocalizedUrl::path('/') }}">{{ __('website.page.home') }}</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">{{ $page->translation('title') }}</span>
        </nav>
        <div class="micro-label"><span>01</span>{{ $page->translation('eyebrow') }}</div>
        <h1>{{ $page->translation('title') }}</h1>
        <p>{{ $page->translation('summary') }}</p>
    </div>
</section>

@if($productProfile)
<section class="product-profile-section" style="--product-accent: {{ $productProfile['accent'] }}">
    <div class="container product-profile-shell reveal">
        <div class="product-profile-core" aria-hidden="true">
            <span>{{ $productProfile['code'] }}</span>
            <div class="product-profile-orbit product-profile-orbit-one"></div>
            <div class="product-profile-orbit product-profile-orbit-two"></div>
            <i></i><i></i><i></i>
        </div>
        <div class="product-profile-data">
            <div class="micro-label"><span>SYS</span>{{ __('website.page.product_profile') }}</div>
            <dl>
                <div><dt>{{ __('website.page.product_category') }}</dt><dd>{{ $productProfile['category'] }}</dd></div>
                <div><dt>{{ __('website.page.product_platform') }}</dt><dd>{{ $productProfile['platform'] }}</dd></div>
                <div><dt>{{ __('website.page.product_deployment') }}</dt><dd>{{ $productProfile['deployment'] }}</dd></div>
                <div><dt>{{ __('website.page.product_status') }}</dt><dd>{{ $productProfile['status'] }}</dd></div>
            </dl>
            <div class="product-feature-cloud">
                @foreach($productProfile['features'] as $feature)<span>{{ $feature }}</span>@endforeach
            </div>
        </div>
    </div>
</section>
@endif

<section class="page-content-section">
    <div class="container content-layout">
        <article class="prose reveal">{!! $page->translation('body') !!}</article>
        <aside class="page-cta reveal">
            <span>Fida Technologies</span>
            <h2>{{ __('website.page.cta_title') }}</h2>
            <p>{{ __('website.page.cta_description') }}</p>
            <a class="button button-lime" href="{{ App\Support\LocalizedUrl::path('/contact') }}" data-track-event="cta_click" data-track-label="{{ $page->slug }}">{{ __('website.page.cta') }} <span class="button-arrow">↗</span></a>
        </aside>
    </div>
</section>

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

@if($relatedPages->isNotEmpty())
<section class="related-pages-section">
    <div class="container">
        <div class="related-pages-heading reveal">
            <div class="micro-label"><span>03</span>{{ __('website.page.related_eyebrow') }}</div>
            <h2>{{ __('website.page.related_title') }}</h2>
        </div>
        <div class="related-pages-grid">
            @foreach($relatedPages as $relatedPage)
                <a class="related-page-card reveal" href="{{ App\Support\LocalizedUrl::path('/'.$relatedPage->slug) }}">
                    <span>0{{ $loop->iteration }} / {{ strtoupper($relatedPage->type) }}</span>
                    <h3>{{ $relatedPage->translation('title') }}</h3>
                    <p>{{ $relatedPage->translation('summary') }}</p>
                    <b>{{ __('website.solutions.learn_more') }} ↗</b>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
