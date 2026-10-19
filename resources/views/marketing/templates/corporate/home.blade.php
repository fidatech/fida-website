@extends('layouts.marketing')

@section('content')
<section class="corp-hero" id="corporate-introduction">
    <div class="container corp-hero-grid">
        <div class="corp-hero-copy">
            <p class="corp-eyebrow">{{ __('website.hero.eyebrow') }} · {{ config('website.address.city') }}</p>
            <h1>{{ __('website.hero.title_before') }} <span>{{ __('website.hero.title_emphasis') }}</span></h1>
            <p class="corp-lead">{{ __('website.hero.description') }}</p>
            <div class="corp-actions">
                <a class="corp-button corp-button-primary" href="{{ \App\Support\LocalizedUrl::path('/contact') }}" data-track-event="cta_click" data-track-label="corporate_hero_contact" aria-label="{{ __('website.hero.primary_cta') }}"><span class="corp-cta-desktop-label">{{ __('website.hero.primary_cta') }}</span><span class="corp-cta-mobile-label">{{ __('website.mobile_cta.proposal') }}</span><span class="corp-cta-arrow" aria-hidden="true">↗</span></a>
                <a class="corp-button corp-button-outline" href="{{ \App\Support\LocalizedUrl::path('/solutions') }}" aria-label="{{ __('website.hero.secondary_cta') }}"><span class="corp-cta-desktop-label">{{ __('website.hero.secondary_cta') }}</span><span class="corp-cta-mobile-label">{{ __('website.mobile_cta.solutions') }}</span><span class="corp-cta-arrow" aria-hidden="true">→</span></a>
            </div>
            <p class="corp-proof">{{ __('website.hero.trust') }}</p>
        </div>
        <figure class="corp-hero-visual">
            <div class="corp-product-window">
                <div class="corp-window-toolbar" aria-hidden="true">
                    <span class="corp-window-dots"><i></i><i></i><i></i></span>
                    <span>ERPNext · {{ config('website.name') }}</span>
                    <span class="corp-window-live">ERP</span>
                </div>
                <img src="https://frappe.io/files/image6f308b.png"
                     alt="ERPNext business dashboard example from the official Frappe website"
                     loading="eager" fetchpriority="high" width="1000" height="625">
            </div>
            <figcaption>
                <span>{{ __('website.editorial.showcase_note') }}</span>
                <a href="{{ \App\Support\LocalizedUrl::path('/erpnext-afghanistan') }}">ERPNext ↗</a>
            </figcaption>
        </figure>
    </div>
</section>

<section class="corp-stats" aria-label="{{ __('website.company.eyebrow') }}">
    <div class="container corp-stats-grid">
        @foreach(config('website.stats') as $stat)
            <div><strong>{{ $stat['value'] }}</strong><span>{{ __("website.stats.{$stat['key']}") }}</span></div>
        @endforeach
    </div>
</section>

<section class="corp-editorial-story">
    <div class="container corp-editorial-grid">
        <div class="corp-editorial-visual">
            <div class="corp-editorial-visual-head">
                <span>ERPNext / {{ __('website.nav.products') }}</span>
                <span aria-hidden="true">↗</span>
            </div>
            <img src="https://frappe.io/files/sales.png"
                 loading="lazy" width="1000" height="507"
                 alt="ERPNext sales dashboard example showing sales orders and operational metrics">
            <small>{{ __('website.editorial.showcase_note') }}</small>
        </div>
        <div class="corp-editorial-narrative">
            <p class="corp-eyebrow">{{ __('website.sections.process_eyebrow') }}</p>
            <h2>{{ __('website.sections.process_title') }}</h2>
            <p class="corp-editorial-summary">{{ __('website.editorial.process_intro') }}</p>
            <div class="corp-editorial-steps">
                @foreach(__('website.editorial.steps') as $step)
                    <div class="corp-editorial-step">
                        <span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <div><h3>{{ $step['title'] }}</h3><p>{{ $step['description'] }}</p></div>
                    </div>
                @endforeach
            </div>
            <a class="corp-editorial-link" href="{{ \App\Support\LocalizedUrl::path('/services') }}">{{ __('website.nav.all_services') }} <span aria-hidden="true">→</span></a>
        </div>
    </div>
</section>

<section class="corp-section" id="corporate-solutions">
    <div class="container">
        <div class="corp-section-head">
            <div><p class="corp-eyebrow">{{ __('website.sections.solutions_eyebrow') }}</p><h2>{{ __('website.sections.solutions_title') }}</h2></div>
            <p>{{ __('website.sections.solutions_description') }}</p>
        </div>
        <div class="corp-service-grid">
            @foreach($solutions as $solution)
                <a class="corp-service-card" href="{{ \App\Support\LocalizedUrl::path($solution['url']) }}">
                    <span class="corp-card-number">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3>{{ __("website.solutions.{$solution['key']}.title") }}</h3>
                    <p>{{ __("website.solutions.{$solution['key']}.description") }}</p>
                    <span class="corp-card-link">{{ __('website.solutions.learn_more') }} ↗</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="corp-section corp-alt" id="corporate-products">
    <div class="container">
        <div class="corp-section-head">
            <div><p class="corp-eyebrow">{{ __('website.sections.products_eyebrow') }}</p><h2>{{ __('website.sections.products_title') }}</h2></div>
            <p>{{ __('website.sections.products_description') }}</p>
        </div>
        <div class="corp-product-grid">
            @foreach($products as $product)
                <article class="corp-product-card">
                    <div class="corp-product-top"><span class="corp-product-symbol" style="--product-accent: {{ $product['accent'] }}">{{ strtoupper(mb_substr($product['key'], 0, 1)) }}</span><small>{{ $product['status'] }}</small></div>
                    <h3>{{ __("website.products.{$product['key']}.name") }}</h3>
                    <p>{{ __("website.products.{$product['key']}.description") }}</p>
                    <a href="{{ \App\Support\LocalizedUrl::path($product['url']) }}" data-track-event="product_view" data-track-label="{{ $product['key'] }}">{{ __('website.products.view') }} ↗</a>
                </article>
            @endforeach
        </div>
        <aside class="corp-erpnext-banner">
            <div><p class="corp-eyebrow">ERPNext · Afghanistan</p><h3>{{ __('website.solutions.erp.title') }}</h3><p>{{ __('website.sections.solutions_description') }}</p></div>
            <a class="corp-button corp-button-primary" href="{{ \App\Support\LocalizedUrl::path('/erpnext-afghanistan') }}">ERPNext ↗</a>
        </aside>
    </div>
</section>

<section class="corp-section" id="corporate-industries">
    <div class="container">
        <div class="corp-section-head"><div><p class="corp-eyebrow">{{ __('website.sections.industries_eyebrow') }}</p><h2>{{ __('website.sections.industries_title') }}</h2></div></div>
        <div class="corp-industries">
            @foreach($industries as $industry)
                <div><span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><strong>{{ __("website.industries.{$industry}") }}</strong></div>
            @endforeach
        </div>
    </div>
</section>

<section class="corp-section corp-alt corp-company">
    <div class="container corp-company-grid">
        <div><p class="corp-eyebrow">{{ __('website.company.eyebrow') }}</p><h2>{{ __('website.company.title') }}</h2><p>{{ __('website.company.description') }}</p><a class="corp-button corp-button-outline" href="{{ \App\Support\LocalizedUrl::path('/about') }}">{{ __('website.nav.about') }} ↗</a></div>
        <div class="corp-company-facts">
            @foreach(__('website.company.facts') as $fact)
                <div><small>{{ $fact['label'] }}</small><strong>{{ $fact['value'] }}</strong></div>
            @endforeach
        </div>
    </div>
</section>

@include('marketing.partials.contact-section', ['sectionClass' => 'corp-contact'])
@endsection
