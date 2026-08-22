<!DOCTYPE html>
@php
    $locale = app()->getLocale();
    $localeConfig = config("website.locales.{$locale}", config('website.locales.en'));
    $direction = $localeConfig['direction'];
@endphp
<html lang="{{ $locale }}" dir="{{ $direction }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#07080b">
    <meta name="color-scheme" content="dark">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">
    @if(config('website.search_verification.google'))<meta name="google-site-verification" content="{{ config('website.search_verification.google') }}">@endif
    @if(config('website.search_verification.bing'))<meta name="msvalidate.01" content="{{ config('website.search_verification.bing') }}">@endif
    <link rel="canonical" href="{{ $seo['canonical'] }}">

    @foreach(config('website.locales') as $code => $language)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ \App\Support\LocalizedUrl::current($code) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ \App\Support\LocalizedUrl::current(config('website.default_locale')) }}">

    <meta property="og:locale" content="{{ str_replace('-', '_', $locale) }}">
    @foreach(config('website.locales') as $code => $language)
        @if($code !== $locale)<meta property="og:locale:alternate" content="{{ str_replace('-', '_', $code) }}">@endif
    @endforeach
    <meta property="og:type" content="{{ $seo['type'] ?? 'website' }}">
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:url" content="{{ $seo['canonical'] }}">
    <meta property="og:site_name" content="{{ config('website.name') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo['title'] }}">
    <meta name="twitter:description" content="{{ $seo['description'] }}">
    @if(config('website.social_image'))
        <meta property="og:image" content="{{ config('website.social_image') }}">
        <meta name="twitter:image" content="{{ config('website.social_image') }}">
    @endif

    @isset($structuredData)
        <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endisset
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="marketing-body">
    <a class="skip-link" href="#main">Skip to content</a>
    <div class="page-noise" aria-hidden="true"></div>
    <div class="page-aurora page-aurora-one" aria-hidden="true"></div>
    <div class="page-aurora page-aurora-two" aria-hidden="true"></div>
    <div class="scroll-progress" data-scroll-progress aria-hidden="true"></div>

    <header class="site-header" data-header>
        <div class="container header-shell">
            <a class="brand" href="{{ \App\Support\LocalizedUrl::path('/') }}" aria-label="Fida Technologies home">
                <span class="brand-mark" aria-hidden="true">
                    <span class="brand-plane brand-plane-back"></span>
                    <span class="brand-plane brand-plane-front">
                        <svg viewBox="0 0 44 44"><path d="M11 9h24v7H19v6h12v7H19v11h-8z" fill="currentColor"/><path d="M30 29h8v11h-8z" fill="currentColor"/></svg>
                    </span>
                </span>
                <span class="brand-copy"><strong>Fida</strong><small>Technologies</small></span>
            </a>

            <nav class="desktop-nav" aria-label="Primary navigation">
                <a href="{{ \App\Support\LocalizedUrl::path('/#solutions') }}"><span>01</span>{{ __('website.nav.solutions') }}</a>
                <a href="{{ \App\Support\LocalizedUrl::path('/#products') }}"><span>02</span>{{ __('website.nav.products') }}</a>
                <a href="{{ \App\Support\LocalizedUrl::path('/#industries') }}"><span>03</span>{{ __('website.nav.industries') }}</a>
                <a href="{{ \App\Support\LocalizedUrl::path('/#process') }}"><span>04</span>{{ __('website.nav.process') }}</a>
            </nav>

            <div class="header-actions">
                <div class="language-switcher" data-language-switcher>
                    <button type="button" class="language-button" data-language-button aria-expanded="false" aria-label="Change language">
                        <span class="language-signal"></span>
                        <b>{{ strtoupper($locale) }}</b>
                        <svg viewBox="0 0 16 16" aria-hidden="true"><path d="m4 6 4 4 4-4"/></svg>
                    </button>
                    <div class="language-menu" data-language-menu>
                        @foreach(config('website.locales') as $code => $language)
                            <a href="{{ \App\Support\LocalizedUrl::current($code) }}" @class(['active' => $code === $locale]) hreflang="{{ $code }}">
                                <span>{{ strtoupper($code) }}</span>{{ $language['native'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <a class="button button-small button-lime header-cta" href="{{ \App\Support\LocalizedUrl::path('/#contact') }}">
                    {{ __('website.nav.proposal') }}<span class="button-arrow">↗</span>
                </a>
                <button class="menu-button" type="button" data-menu-button aria-expanded="false" aria-label="{{ __('website.nav.menu') }}">
                    <span></span><span></span>
                </button>
            </div>
        </div>

        <nav class="mobile-nav" data-mobile-nav aria-label="Mobile navigation">
            <a href="{{ \App\Support\LocalizedUrl::path('/#solutions') }}"><span>01</span>{{ __('website.nav.solutions') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/#products') }}"><span>02</span>{{ __('website.nav.products') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/#industries') }}"><span>03</span>{{ __('website.nav.industries') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/#process') }}"><span>04</span>{{ __('website.nav.process') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/#contact') }}"><span>05</span>{{ __('website.nav.proposal') }}</a>
        </nav>
    </header>

    <main id="main">@yield('content')</main>

    <footer class="site-footer">
        <div class="container footer-shell">
            <div class="footer-top">
                <div class="footer-brand">
                    <a class="brand" href="{{ \App\Support\LocalizedUrl::path('/') }}">
                        <span class="brand-mark" aria-hidden="true"><span class="brand-plane brand-plane-back"></span><span class="brand-plane brand-plane-front"><svg viewBox="0 0 44 44"><path d="M11 9h24v7H19v6h12v7H19v11h-8z" fill="currentColor"/><path d="M30 29h8v11h-8z" fill="currentColor"/></svg></span></span>
                        <span class="brand-copy"><strong>Fida</strong><small>Technologies</small></span>
                    </a>
                    <p>{{ __('website.footer.description') }}</p>
                </div>
                <div class="footer-status"><span class="live-dot"></span><div><small>FIDA SYSTEM STATUS</small><strong>Building what’s next</strong></div></div>
            </div>
            <div class="footer-grid">
                <div>
                    <span class="footer-heading">{{ __('website.footer.company') }}</span>
                    <a href="{{ \App\Support\LocalizedUrl::path('/erp-systems-afghanistan') }}">ERP Systems</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/custom-software-development-afghanistan') }}">Custom Software</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/mobile-app-development-afghanistan') }}">Mobile Apps</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/technology-company-afghanistan') }}">Technology Company</a>
                </div>
                <div>
                    <span class="footer-heading">{{ __('website.footer.contact') }}</span>
                    <a href="mailto:{{ config('website.email') }}">{{ config('website.email') }}</a>
                    <a href="tel:{{ config('website.phone') }}" dir="ltr">{{ config('website.phone') }}</a>
                    <span>{{ config('website.address.city') }}, {{ config('website.address.country') }}</span>
                </div>
                <div class="footer-coordinate"><span class="footer-heading">LOCAL / GLOBAL</span><strong>34.5553° N<br>69.2075° E</strong></div>
            </div>
            <div class="footer-bottom">
                <span>© {{ now()->year }} {{ config('website.name') }}. {{ __('website.footer.rights') }}</span>
                <span>LARAVEL · SECURE · MULTILINGUAL</span>
            </div>
        </div>
    </footer>
</body>
</html>
