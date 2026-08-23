<!DOCTYPE html>
@php
    $locale = app()->getLocale();
    $localeConfig = config("website.locales.{$locale}", config('website.locales.en'));
    $direction = $localeConfig['direction'];
    $routePage = request()->route('page');
    $currentSlug = $routePage instanceof \App\Models\ContentPage ? $routePage->slug : null;
    $homeActive = request()->routeIs('home', 'localized.home');
    $servicesActive = in_array($currentSlug, ['services', 'solutions'], true) || ($routePage instanceof \App\Models\ContentPage && in_array($routePage->type, ['solution', 'service'], true));
    $productsActive = in_array($currentSlug, ['products', 'projects', 'case-studies'], true) || ($routePage instanceof \App\Models\ContentPage && in_array($routePage->type, ['product', 'case-study'], true));
    $industriesActive = $currentSlug === 'industries' || ($routePage instanceof \App\Models\ContentPage && $routePage->type === 'industry');
    $articlesActive = request()->routeIs('articles.*', 'localized.articles.*') || $currentSlug === 'articles' || ($routePage instanceof \App\Models\ContentPage && $routePage->type === 'article');
    $navServices = $navigationPages->get('service', collect());
    $navSolutions = $navigationPages->get('solution', collect());
    $navProducts = $navigationPages->get('product', collect());
    $navCaseStudies = $navigationPages->get('case-study', collect());
    $navIndustries = $navigationPages->get('industry', collect());
    $navArticles = $navigationPages->get('article', collect());
    $siteTheme = config('website.appearance.current_theme_values', config('website.appearance.themes.midnight'));
    $siteColors = config('website.appearance.current_colors', config('website.appearance.palettes.fida'));
    $siteRgb = config('website.appearance.rgb', ['primary' => '201,255,74', 'secondary' => '132,108,255', 'highlight' => '78,232,255']);
@endphp
<html lang="{{ $locale }}" dir="{{ $direction }}" style="--ink:{{ $siteTheme['background'] }};--ink-soft:{{ $siteTheme['background_soft'] }};--panel-solid:{{ $siteTheme['surface'] }};--lime:{{ $siteColors['primary'] }};--lime-soft:{{ $siteColors['primary_soft'] }};--violet:{{ $siteColors['secondary'] }};--cyan:{{ $siteColors['highlight'] }};--accent-rgb:{{ $siteRgb['primary'] }};--secondary-rgb:{{ $siteRgb['secondary'] }};--highlight-rgb:{{ $siteRgb['highlight'] }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="{{ $siteTheme['background'] }}" data-theme-color data-dark-color="{{ $siteTheme['background'] }}">
    <meta name="color-scheme" content="dark light">
    <script>
        (() => {
            const key = 'fida_color_mode';
            let saved = null;
            try { saved = localStorage.getItem(key); } catch (error) {}
            const mode = saved === 'light' || saved === 'dark'
                ? saved
                : (matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark');
            document.documentElement.dataset.colorMode = mode;
        })();
    </script>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="robots" content="{{ config('website.indexable') ? ($seo['robots'] ?? 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1') : 'noindex,nofollow,noarchive' }}">
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
    @if($seo['image'] ?? config('website.social_image'))
        <meta property="og:image" content="{{ $seo['image'] ?? config('website.social_image') }}">
        <meta name="twitter:image" content="{{ $seo['image'] ?? config('website.social_image') }}">
    @endif
    @if($seo['author'] ?? null)<meta name="author" content="{{ $seo['author'] }}">@endif

    @isset($structuredData)
        <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endisset
    @if(config('website.indexable') && config('website.analytics.ga4_measurement_id'))
        <script>
            window.fidaAnalytics = {
                measurementId: @json((string) config('website.analytics.ga4_measurement_id')),
                requireConsent: @json((bool) config('website.analytics.require_consent')),
            };
        </script>
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="marketing-body theme-{{ config('website.appearance.current_theme', 'midnight') }} palette-{{ config('website.appearance.current_palette', 'fida') }}">
    <a class="skip-link" href="#main">Skip to content</a>
    <div class="page-noise" aria-hidden="true"></div>
    <div class="page-aurora page-aurora-one" aria-hidden="true"></div>
    <div class="page-aurora page-aurora-two" aria-hidden="true"></div>
    <div class="scroll-progress" data-scroll-progress aria-hidden="true"></div>

    <header class="site-header" data-header>
        <div class="container header-shell">
            <a class="brand" href="{{ \App\Support\LocalizedUrl::path('/') }}" aria-label="{{ config('website.name') }} home">
                @if(config('website.branding.logo_url'))
                    <span class="brand-logo"><img src="{{ config('website.branding.logo_url') }}" alt="" width="42" height="42"></span>
                @else
                    <span class="brand-mark" aria-hidden="true">
                        <span class="brand-plane brand-plane-back"></span>
                        <span class="brand-plane brand-plane-front">
                            <svg viewBox="0 0 44 44"><path d="M11 9h24v7H19v6h12v7H19v11h-8z" fill="currentColor"/><path d="M30 29h8v11h-8z" fill="currentColor"/></svg>
                        </span>
                    </span>
                @endif
                <span class="brand-copy"><strong>{{ config('website.branding.name') }}</strong><small>{{ config('website.branding.tagline') }}</small></span>
            </a>

            <nav class="desktop-nav" aria-label="Primary navigation">
                <a href="{{ \App\Support\LocalizedUrl::path('/') }}" @class(['active' => $homeActive])><span>01</span>{{ __('website.nav.home') }}</a>
                <a href="{{ \App\Support\LocalizedUrl::path('/about') }}" @class(['active' => $currentSlug === 'about'])><span>02</span>{{ __('website.nav.about') }}</a>
                <div @class(['nav-cluster', 'active' => $servicesActive]) data-nav-cluster>
                    <button type="button" data-nav-cluster-button aria-expanded="false"><span>03</span>{{ __('website.nav.services') }}<svg viewBox="0 0 16 16"><path d="m4 6 4 4 4-4"/></svg></button>
                    <div class="nav-cluster-menu nav-mega-menu nav-mega-menu-services">
                        <section>
                            <span class="nav-cluster-heading">{{ __('website.nav.services') }}</span>
                            <a class="nav-cluster-overview" href="{{ \App\Support\LocalizedUrl::path('/services') }}">{{ __('website.nav.all_services') }}<small>↗</small></a>
                            @foreach($navServices as $navPage)
                                <a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}<small>↗</small></a>
                            @endforeach
                        </section>
                        <section>
                            <span class="nav-cluster-heading">{{ __('website.nav.solutions') }}</span>
                            <a class="nav-cluster-overview" href="{{ \App\Support\LocalizedUrl::path('/solutions') }}">{{ __('website.nav.all_solutions') }}<small>↗</small></a>
                            @foreach($navSolutions as $navPage)
                                <a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}<small>↗</small></a>
                            @endforeach
                        </section>
                    </div>
                </div>
                <div @class(['nav-cluster', 'active' => $productsActive]) data-nav-cluster>
                    <button type="button" data-nav-cluster-button aria-expanded="false"><span>04</span>{{ __('website.nav.products') }}<svg viewBox="0 0 16 16"><path d="m4 6 4 4 4-4"/></svg></button>
                    <div class="nav-cluster-menu nav-mega-menu nav-mega-menu-products">
                        <section>
                            <span class="nav-cluster-heading">{{ __('website.nav.products') }}</span>
                            <a class="nav-cluster-overview" href="{{ \App\Support\LocalizedUrl::path('/products') }}">{{ __('website.nav.all_products') }}<small>↗</small></a>
                            @foreach($navProducts as $navPage)
                                <a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}<small>↗</small></a>
                            @endforeach
                        </section>
                        <section>
                            <span class="nav-cluster-heading">{{ __('website.nav.projects') }}</span>
                            <a href="{{ \App\Support\LocalizedUrl::path('/projects') }}">{{ __('website.nav.projects') }}<small>↗</small></a>
                            <a href="{{ \App\Support\LocalizedUrl::path('/case-studies') }}">{{ __('website.nav.case_studies') }}<small>↗</small></a>
                            @foreach($navCaseStudies as $navPage)
                                <a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}<small>↗</small></a>
                            @endforeach
                        </section>
                    </div>
                </div>
                <div @class(['nav-cluster', 'active' => $industriesActive]) data-nav-cluster>
                    <button type="button" data-nav-cluster-button aria-expanded="false"><span>05</span>{{ __('website.nav.industries') }}<svg viewBox="0 0 16 16"><path d="m4 6 4 4 4-4"/></svg></button>
                    <div class="nav-cluster-menu nav-mega-menu nav-mega-menu-single nav-mega-menu-align-right">
                        <section>
                            <span class="nav-cluster-heading">{{ __('website.nav.industries') }}</span>
                            <a class="nav-cluster-overview" href="{{ \App\Support\LocalizedUrl::path('/industries') }}">{{ __('website.nav.all_industries') }}<small>↗</small></a>
                            @foreach($navIndustries as $navPage)
                                <a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}<small>↗</small></a>
                            @endforeach
                        </section>
                    </div>
                </div>
                <div @class(['nav-cluster', 'active' => $articlesActive]) data-nav-cluster>
                    <button type="button" data-nav-cluster-button aria-expanded="false"><span>06</span>{{ __('website.nav.articles') }}<svg viewBox="0 0 16 16"><path d="m4 6 4 4 4-4"/></svg></button>
                    <div class="nav-cluster-menu nav-mega-menu nav-mega-menu-single nav-mega-menu-align-right">
                        <section>
                            <span class="nav-cluster-heading">{{ __('website.nav.articles') }}</span>
                            <a class="nav-cluster-overview" href="{{ \App\Support\LocalizedUrl::path('/articles') }}">{{ __('website.nav.all_articles') }}<small>↗</small></a>
                            @foreach($navArticles as $navPage)
                                <a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}<small>↗</small></a>
                            @endforeach
                        </section>
                    </div>
                </div>
                <a href="{{ \App\Support\LocalizedUrl::path('/pricing') }}" @class(['active' => $currentSlug === 'pricing'])><span>07</span>{{ __('website.nav.pricing') }}</a>
            </nav>

            <div class="header-actions">
                <a class="header-search-button" href="{{ \App\Support\LocalizedUrl::path('/search') }}" aria-label="{{ __('website.search.title') }}" title="{{ __('website.search.title') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6"/><path d="m16 16 4 4"/></svg>
                </a>
                <button class="color-mode-button" type="button" data-color-mode-toggle data-light-label="{{ __('website.nav.light_mode') }}" data-dark-label="{{ __('website.nav.dark_mode') }}" aria-label="{{ __('website.nav.light_mode') }}" title="{{ __('website.nav.light_mode') }}">
                    <svg class="mode-sun" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.42-1.42M17.66 6.34l1.41-1.41"/></svg>
                    <svg class="mode-moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 15.1A8.5 8.5 0 0 1 8.9 3.5 8.5 8.5 0 1 0 20.5 15.1Z"/></svg>
                </button>
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
                <a class="button button-small button-lime header-cta" href="{{ \App\Support\LocalizedUrl::path('/contact') }}" data-track-event="cta_click" data-track-label="header_contact">
                    {{ __('website.nav.contact') }}<span class="button-arrow">↗</span>
                </a>
                <button class="menu-button" type="button" data-menu-button aria-expanded="false" aria-label="{{ __('website.nav.menu') }}">
                    <span></span><span></span>
                </button>
            </div>
        </div>

        <nav class="mobile-nav" data-mobile-nav aria-label="Mobile navigation">
            <a href="{{ \App\Support\LocalizedUrl::path('/') }}"><span>01</span>{{ __('website.nav.home') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/about') }}"><span>02</span>{{ __('website.nav.about') }}</a>
            <details class="mobile-nav-group">
                <summary><span>03</span>{{ __('website.nav.services') }}<i>+</i></summary>
                <div>
                    <a href="{{ \App\Support\LocalizedUrl::path('/services') }}">{{ __('website.nav.all_services') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/solutions') }}">{{ __('website.nav.all_solutions') }}</a>
                    @foreach($navServices->concat($navSolutions) as $navPage)<a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}</a>@endforeach
                </div>
            </details>
            <details class="mobile-nav-group">
                <summary><span>04</span>{{ __('website.nav.products') }}<i>+</i></summary>
                <div>
                    <a href="{{ \App\Support\LocalizedUrl::path('/products') }}">{{ __('website.nav.all_products') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/projects') }}">{{ __('website.nav.projects') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/case-studies') }}">{{ __('website.nav.case_studies') }}</a>
                    @foreach($navProducts as $navPage)<a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}</a>@endforeach
                </div>
            </details>
            <details class="mobile-nav-group">
                <summary><span>05</span>{{ __('website.nav.industries') }}<i>+</i></summary>
                <div>
                    <a href="{{ \App\Support\LocalizedUrl::path('/industries') }}">{{ __('website.nav.all_industries') }}</a>
                    @foreach($navIndustries as $navPage)<a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}</a>@endforeach
                </div>
            </details>
            <details class="mobile-nav-group">
                <summary><span>06</span>{{ __('website.nav.articles') }}<i>+</i></summary>
                <div>
                    <a href="{{ \App\Support\LocalizedUrl::path('/articles') }}">{{ __('website.nav.all_articles') }}</a>
                    @foreach($navArticles as $navPage)<a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}</a>@endforeach
                </div>
            </details>
            <a href="{{ \App\Support\LocalizedUrl::path('/search') }}"><span>07</span>{{ __('website.search.title') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/pricing') }}"><span>08</span>{{ __('website.nav.pricing') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/contact') }}"><span>09</span>{{ __('website.nav.contact') }}</a>
        </nav>
    </header>

    <main id="main">@yield('content')</main>

    <footer class="site-footer">
        <div class="container footer-shell">
            <div class="footer-top">
                <div class="footer-brand">
                    <a class="brand" href="{{ \App\Support\LocalizedUrl::path('/') }}">
                        @if(config('website.branding.logo_url'))
                            <span class="brand-logo"><img src="{{ config('website.branding.logo_url') }}" alt="" width="42" height="42"></span>
                        @else
                            <span class="brand-mark" aria-hidden="true"><span class="brand-plane brand-plane-back"></span><span class="brand-plane brand-plane-front"><svg viewBox="0 0 44 44"><path d="M11 9h24v7H19v6h12v7H19v11h-8z" fill="currentColor"/><path d="M30 29h8v11h-8z" fill="currentColor"/></svg></span></span>
                        @endif
                        <span class="brand-copy"><strong>{{ config('website.branding.name') }}</strong><small>{{ config('website.branding.tagline') }}</small></span>
                    </a>
                    <p>{{ __('website.footer.description') }}</p>
                </div>
                <div class="footer-status"><span class="live-dot"></span><div><small>FIDA SYSTEM STATUS</small><strong>Building what’s next</strong></div></div>
            </div>
            <div class="footer-grid">
                <div>
                    <span class="footer-heading">{{ __('website.footer.company') }}</span>
                    <a href="{{ \App\Support\LocalizedUrl::path('/about') }}">{{ __('website.nav.about') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/services') }}">{{ __('website.nav.services') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/solutions') }}">{{ __('website.nav.solutions') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/industries') }}">{{ __('website.nav.industries') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/projects') }}">{{ __('website.nav.projects') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/pricing') }}">{{ __('website.nav.pricing') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/contact') }}">{{ __('website.nav.contact') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/privacy-policy') }}">{{ __('website.footer.privacy') }}</a>
                </div>
                <div>
                    <span class="footer-heading">{{ __('website.footer.expertise') }}</span>
                    <a href="{{ \App\Support\LocalizedUrl::path('/erp-systems-afghanistan') }}">ERP Systems</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/custom-software-development-afghanistan') }}">Custom Software</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/mobile-app-development-afghanistan') }}">Mobile Apps</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/technology-company-afghanistan') }}">Technology Company</a>
                </div>
                <div>
                    <span class="footer-heading">{{ __('website.footer.products') }}</span>
                    <a href="{{ \App\Support\LocalizedUrl::path('/products') }}">{{ __('website.nav.products') }}</a>
                    @foreach(config('website.products') as $product)
                        <a href="{{ \App\Support\LocalizedUrl::path($product['url']) }}">{{ __("website.products.{$product['key']}.name") }}</a>
                    @endforeach
                    <a href="{{ \App\Support\LocalizedUrl::path('/case-studies') }}">{{ __('website.nav.case_studies') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/articles') }}">{{ __('website.nav.articles') }}</a>
                </div>
                <div>
                    <span class="footer-heading">{{ __('website.footer.contact') }}</span>
                    <a href="mailto:{{ config('website.email') }}">{{ config('website.email') }}</a>
                    <a href="tel:{{ config('website.phone') }}" dir="ltr">{{ config('website.phone') }}</a>
                    @if(config('website.address.line'))<span>{{ config('website.address.line') }}</span>@endif
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

    @if(config('website.indexable') && config('website.analytics.ga4_measurement_id'))
        <aside class="analytics-consent" data-analytics-consent hidden aria-label="{{ __('website.analytics.title') }}">
            <div>
                <strong>{{ __('website.analytics.title') }}</strong>
                <p>{{ __('website.analytics.description') }} <a href="{{ \App\Support\LocalizedUrl::path('/privacy-policy') }}">{{ __('website.footer.privacy') }}</a></p>
            </div>
            <div class="analytics-consent-actions">
                <button type="button" class="button button-wire" data-analytics-decline>{{ __('website.analytics.decline') }}</button>
                <button type="button" class="button button-lime" data-analytics-accept>{{ __('website.analytics.accept') }}</button>
            </div>
        </aside>
    @endif
</body>
</html>
