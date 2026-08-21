<!DOCTYPE html>
@php
    $locale = app()->getLocale();
    $localeConfig = config("website.locales.{$locale}", config('website.locales.en'));
    $direction = $localeConfig['direction'];
    $organizationSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        '@id' => url('/').'#organization',
        'name' => config('website.name'),
        'legalName' => config('website.legal_name'),
        'url' => url('/'),
        'email' => config('website.email'),
        'telephone' => config('website.phone'),
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => config('website.address.city'),
            'addressCountry' => config('website.address.country_code'),
        ],
    ];
@endphp
<html lang="{{ $locale }}" dir="{{ $direction }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#07111f">
    <meta name="color-scheme" content="dark">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">
    <link rel="canonical" href="{{ $seo['canonical'] }}">

    @foreach(config('website.locales') as $code => $language)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ \App\Support\LocalizedUrl::current($code) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ \App\Support\LocalizedUrl::current(config('website.default_locale')) }}">

    <meta property="og:locale" content="{{ str_replace('-', '_', $locale) }}">
    <meta property="og:type" content="{{ $seo['type'] ?? 'website' }}">
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:url" content="{{ $seo['canonical'] }}">
    <meta property="og:site_name" content="{{ config('website.name') }}">
    <meta name="twitter:card" content="summary_large_image">

    <script type="application/ld+json">{!! json_encode($organizationSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#main">Skip to content</a>

    <header class="site-header" data-header>
        <div class="container header-inner">
            <a class="brand" href="{{ \App\Support\LocalizedUrl::path('/') }}" aria-label="Fida Technologies home">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 44 44" role="img"><path d="M11 10.5h22v7H19v5h11v7H19v10H11z" fill="currentColor"/><path d="M30 29.5h7v10h-7z" fill="#36d1ba"/></svg>
                </span>
                <span class="brand-copy"><strong>Fida</strong><small>Technologies</small></span>
            </a>

            <nav class="desktop-nav" aria-label="Primary navigation">
                <a href="{{ \App\Support\LocalizedUrl::path('/#solutions') }}">{{ __('website.nav.solutions') }}</a>
                <a href="{{ \App\Support\LocalizedUrl::path('/#products') }}">{{ __('website.nav.products') }}</a>
                <a href="{{ \App\Support\LocalizedUrl::path('/#industries') }}">{{ __('website.nav.industries') }}</a>
                <a href="{{ \App\Support\LocalizedUrl::path('/#process') }}">{{ __('website.nav.process') }}</a>
            </nav>

            <div class="header-actions">
                <div class="language-switcher" data-language-switcher>
                    <button type="button" class="language-button" data-language-button aria-expanded="false">
                        <span>{{ strtoupper($locale) }}</span>
                        <svg viewBox="0 0 16 16" aria-hidden="true"><path d="m4 6 4 4 4-4"/></svg>
                    </button>
                    <div class="language-menu" data-language-menu>
                        @foreach(config('website.locales') as $code => $language)
                            <a href="{{ \App\Support\LocalizedUrl::current($code) }}" @class(['active' => $code === $locale]) hreflang="{{ $code }}">
                                {{ $language['native'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <a class="button button-small button-primary header-cta" href="{{ \App\Support\LocalizedUrl::path('/#contact') }}">{{ __('website.nav.proposal') }}</a>
                <button class="menu-button" type="button" data-menu-button aria-expanded="false" aria-label="{{ __('website.nav.menu') }}">
                    <span></span><span></span>
                </button>
            </div>
        </div>

        <nav class="mobile-nav" data-mobile-nav aria-label="Mobile navigation">
            <a href="{{ \App\Support\LocalizedUrl::path('/#solutions') }}">{{ __('website.nav.solutions') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/#products') }}">{{ __('website.nav.products') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/#industries') }}">{{ __('website.nav.industries') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/#process') }}">{{ __('website.nav.process') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/#contact') }}">{{ __('website.nav.proposal') }}</a>
        </nav>
    </header>

    <main id="main">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div class="footer-brand">
                <a class="brand" href="{{ \App\Support\LocalizedUrl::path('/') }}">
                    <span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 44 44"><path d="M11 10.5h22v7H19v5h11v7H19v10H11z" fill="currentColor"/><path d="M30 29.5h7v10h-7z" fill="#36d1ba"/></svg></span>
                    <span class="brand-copy"><strong>Fida</strong><small>Technologies</small></span>
                </a>
                <p>{{ __('website.footer.description') }}</p>
            </div>
            <div>
                <span class="footer-heading">{{ __('website.footer.company') }}</span>
                <a href="{{ \App\Support\LocalizedUrl::path('/erp-systems-afghanistan') }}">ERP</a>
                <a href="{{ \App\Support\LocalizedUrl::path('/custom-software-development-afghanistan') }}">Software Development</a>
                <a href="{{ \App\Support\LocalizedUrl::path('/mobile-app-development-afghanistan') }}">Mobile Apps</a>
            </div>
            <div>
                <span class="footer-heading">{{ __('website.footer.contact') }}</span>
                <a href="mailto:{{ config('website.email') }}">{{ config('website.email') }}</a>
                <a href="tel:{{ config('website.phone') }}" dir="ltr">{{ config('website.phone') }}</a>
                <span>{{ config('website.address.city') }}, {{ config('website.address.country') }}</span>
            </div>
        </div>
        <div class="container footer-bottom">
            <span>© {{ now()->year }} {{ config('website.name') }}. {{ __('website.footer.rights') }}</span>
            <span>Laravel · Secure · Multilingual</span>
        </div>
    </footer>
</body>
</html>
