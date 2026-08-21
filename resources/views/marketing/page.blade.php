@extends('layouts.marketing')

@section('content')
<section class="page-hero">
    <div class="page-hero-glow"></div>
    <div class="container narrow reveal">
        <a class="back-link" href="{{ App\Support\LocalizedUrl::path('/') }}">← {{ __('website.page.back') }}</a>
        <div class="eyebrow"><span></span>{{ $page->translation('eyebrow') }}</div>
        <h1>{{ $page->translation('title') }}</h1>
        <p>{{ $page->translation('summary') }}</p>
    </div>
</section>

<section class="page-content-section">
    <div class="container content-layout">
        <article class="prose reveal">{!! $page->translation('body') !!}</article>
        <aside class="page-cta reveal">
            <span>Fida Technologies</span>
            <h2>{{ __('website.page.cta_title') }}</h2>
            <p>{{ __('website.page.cta_description') }}</p>
            <a class="button button-primary" href="{{ App\Support\LocalizedUrl::path('/#contact') }}">{{ __('website.page.cta') }} ↗</a>
        </aside>
    </div>
</section>
@endsection
