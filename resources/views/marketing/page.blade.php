@extends('layouts.marketing')

@section('content')
<section @class(['page-hero', 'product-page-hero' => $productProfile, 'detail-page-hero', 'detail-page-hero-'.$page->type]) @if($productProfile) style="--product-accent: {{ $productProfile['accent'] }}" @endif>
    <div class="page-hero-glow"></div>
    <div class="container narrow reveal">
        <nav class="page-breadcrumbs" aria-label="{{ __('website.page.breadcrumbs') }}">
            <a href="{{ App\Support\LocalizedUrl::path('/') }}">{{ __('website.page.home') }}</a>
            <span aria-hidden="true">/</span>
            @if($archive)
                <a href="{{ $archive['path'] }}">{{ $archive['label'] }}</a>
                <span aria-hidden="true">/</span>
            @endif
            <span aria-current="page">{{ $page->translation('title') }}</span>
        </nav>
        <div class="micro-label"><span>01</span>{{ $page->translation('eyebrow') }}</div>
        <h1>{{ $page->translation('title') }}</h1>
        <p>{{ $page->translation('summary') }}</p>
        @if(($page->type === 'article' && $page->published_at) || $page->author_name || $page->reviewer_name)
            <div class="article-meta">
                @if($page->type === 'article' && $page->published_at)
                    <span>{{ __('website.page.article') }}</span><span aria-hidden="true">·</span><span>{{ __('website.page.published') }}</span><time datetime="{{ $page->published_at->toDateString() }}">{{ $page->published_at->format('Y-m-d') }}</time>
                @endif
                @if($page->articleCategory?->active)
                    <span aria-hidden="true">·</span><a href="{{ App\Support\LocalizedUrl::path('/articles/category/'.$page->articleCategory->slug) }}">{{ $page->articleCategory->translation('name') }}</a>
                @endif
                @if($page->byline())
                    <span aria-hidden="true">·</span>
                    @if($page->articleAuthor?->active)
                        <a href="{{ App\Support\LocalizedUrl::path('/articles/author/'.$page->articleAuthor->slug) }}">{{ __('website.page.by') }} {{ $page->byline() }}</a>
                    @else
                        <span>{{ __('website.page.by') }} {{ $page->byline() }}</span>
                    @endif
                @endif
                @if($page->reviewer_name)
                    <span aria-hidden="true">·</span><span>{{ __('website.page.reviewed_by') }} {{ $page->reviewer_name }}</span>
                    @if($page->reviewed_at)<time datetime="{{ $page->reviewed_at->toDateString() }}">{{ $page->reviewed_at->format('Y-m-d') }}</time>@endif
                @endif
            </div>
        @endif
    </div>
</section>

@yield('detail_profile')

<section class="page-content-section">
    <div class="container content-layout">
        <article class="prose reveal">{!! $page->translation('body') !!}</article>
        @php
            $primaryIntent = $callToAction['primary_intent'] ?? 'proposal';
            $primaryParameters = ['interest' => $page->slug];
            if ($primaryIntent !== 'proposal') {
                $primaryParameters['request'] = $primaryIntent;
            }
            $primaryCtaUrl = $primaryIntent === 'tender'
                ? App\Support\LocalizedUrl::path('/request-for-quotation').'?'.http_build_query(['interest' => $page->slug]).'#rfq'
                : App\Support\LocalizedUrl::path('/contact').'?'.http_build_query($primaryParameters).'#contact';

            $secondaryCtaUrl = null;
            if (($callToAction['secondary_label'] ?? '') !== '' && ($callToAction['secondary_intent'] ?? null)) {
                $secondaryCtaUrl = $callToAction['secondary_intent'] === 'tender'
                    ? App\Support\LocalizedUrl::path('/request-for-quotation').'?'.http_build_query(['interest' => $page->slug]).'#rfq'
                    : App\Support\LocalizedUrl::path('/contact').'?'.http_build_query([
                        'interest' => $page->slug,
                        'request' => $callToAction['secondary_intent'],
                    ]).'#contact';
            }
        @endphp
        <aside class="page-cta reveal">
            <span>{{ config('website.name') }}</span>
            <h2>{{ ($callToAction['heading'] ?? '') !== '' ? $callToAction['heading'] : __('website.page.cta_title') }}</h2>
            <p>{{ ($callToAction['description'] ?? '') !== '' ? $callToAction['description'] : __('website.page.cta_description') }}</p>
            <div class="page-cta-actions">
                <a class="button button-lime" href="{{ $primaryCtaUrl }}" data-track-event="cta_click" data-track-label="{{ $page->slug }}:{{ $primaryIntent }}">{{ ($callToAction['primary_label'] ?? '') !== '' ? $callToAction['primary_label'] : __('website.page.cta') }} <span class="button-arrow">↗</span></a>
                @if($secondaryCtaUrl)
                    <a class="button button-wire" href="{{ $secondaryCtaUrl }}" data-track-event="cta_click" data-track-label="{{ $page->slug }}:{{ $callToAction['secondary_intent'] }}">{{ $callToAction['secondary_label'] }}</a>
                @endif
            </div>
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
                    @if($relatedPage->type === 'article' && ($relatedPage->articleCategory || $relatedPage->byline()))
                        <small>{{ $relatedPage->articleCategory?->translation('name') }}@if($relatedPage->articleCategory && $relatedPage->byline()) · @endif{{ $relatedPage->byline() }}</small>
                    @endif
                    <b>{{ __('website.solutions.learn_more') }} ↗</b>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
