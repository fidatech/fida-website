<!DOCTYPE html>
@php
    $locale = app()->getLocale();
    $localeConfig = config("website.locales.{$locale}", config('website.locales.en'));
    $direction = $localeConfig['direction'];
    $routePage = request()->route('page');
    $currentSlug = $routePage instanceof \App\Models\ContentPage ? $routePage->slug : null;
    $solutionsActive = $currentSlug === 'solutions' || ($routePage instanceof \App\Models\ContentPage && $routePage->type === 'solution');
    $servicesActive = $currentSlug === 'services' || ($routePage instanceof \App\Models\ContentPage && $routePage->type === 'service');
    $productsActive = in_array($currentSlug, ['products', 'projects'], true) || ($routePage instanceof \App\Models\ContentPage && $routePage->type === 'product');
    $caseStudiesActive = $currentSlug === 'case-studies' || ($routePage instanceof \App\Models\ContentPage && $routePage->type === 'case-study');
    $industriesActive = $currentSlug === 'industries' || ($routePage instanceof \App\Models\ContentPage && $routePage->type === 'industry');
    $articlesActive = request()->routeIs('articles.*', 'localized.articles.*') || $currentSlug === 'articles' || ($routePage instanceof \App\Models\ContentPage && $routePage->type === 'article');
    $projectsActive = $productsActive || $caseStudiesActive;
    $pricingActive = $currentSlug === 'pricing';
    $companyActive = $currentSlug === 'about' || $articlesActive;
    $navServices = $navigationPages->get('service', collect());
    $navSolutions = $navigationPages->get('solution', collect());
    $navProducts = $navigationPages->get('product', collect());
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="{{ $siteTheme['background'] }}" data-theme-color data-dark-color="{{ $siteTheme['background'] }}">
    <meta name="color-scheme" content="dark light">
    <script>
        (() => {
            const key = 'fida_color_mode';
            let saved = null;
            try { saved = localStorage.getItem(key); } catch (error) {}
            const mode = saved === 'light' || saved === 'dark'
                ? saved
                : 'dark';
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
        <link rel="alternate" hreflang="{{ $language['hreflang'] ?? $code }}" href="{{ \App\Support\LocalizedUrl::current($code) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ \App\Support\LocalizedUrl::current(config('website.default_locale')) }}">

    <meta property="og:locale" content="{{ $localeConfig['og_locale'] ?? str_replace('-', '_', $locale) }}">
    @foreach(config('website.locales') as $code => $language)
        @if($code !== $locale)<meta property="og:locale:alternate" content="{{ $language['og_locale'] ?? str_replace('-', '_', $code) }}">@endif
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
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="{{ __('website.seo.social_image_alt') }}">
        <meta name="twitter:image" content="{{ $seo['image'] ?? config('website.social_image') }}">
        <meta name="twitter:image:alt" content="{{ __('website.seo.social_image_alt') }}">
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
    <a class="skip-link" href="#main">{{ __('website.accessibility.skip_to_content') }}</a>
    <div class="page-noise" aria-hidden="true"></div>
    <div class="page-aurora page-aurora-one" aria-hidden="true"></div>
    <div class="page-aurora page-aurora-two" aria-hidden="true"></div>
    <div class="scroll-progress" data-scroll-progress aria-hidden="true"></div>

    <header class="site-header" data-header>
        <div class="container header-shell">
            <a class="brand" href="{{ \App\Support\LocalizedUrl::path('/') }}" aria-label="{{ __('website.accessibility.home', ['company' => config('website.name')]) }}">
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

            <nav class="desktop-nav" aria-label="{{ __('website.accessibility.primary_navigation') }}">
                <div @class(['nav-cluster', 'nav-cluster-wide', 'active' => $solutionsActive]) data-nav-cluster>
                    <button type="button" data-nav-cluster-button aria-expanded="false">{{ __('website.nav.solutions') }}<svg viewBox="0 0 16 16"><path d="m4 6 4 4 4-4"/></svg></button>
                    <div class="nav-cluster-menu nav-mega-menu nav-mega-menu-columns nav-mega-menu-columns-2">
                        <section>
                            <span class="nav-cluster-heading">{{ __('website.nav.solutions') }}</span>
                            <a class="nav-cluster-overview" href="{{ \App\Support\LocalizedUrl::path('/solutions') }}">{{ __('website.nav.all_solutions') }}<small>↗</small></a>
                            <div class="nav-mega-link-grid">
                                @foreach($navSolutions as $navPage)
                                    <a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}<small>↗</small></a>
                                @endforeach
                            </div>
                        </section>
                    </div>
                </div>
                <div @class(['nav-cluster', 'nav-cluster-wide', 'active' => $servicesActive]) data-nav-cluster>
                    <button type="button" data-nav-cluster-button aria-expanded="false">{{ __('website.nav.services') }}<svg viewBox="0 0 16 16"><path d="m4 6 4 4 4-4"/></svg></button>
                    <div class="nav-cluster-menu nav-mega-menu nav-mega-menu-columns nav-mega-menu-columns-2">
                        <section>
                            <span class="nav-cluster-heading">{{ __('website.nav.services') }}</span>
                            <a class="nav-cluster-overview" href="{{ \App\Support\LocalizedUrl::path('/services') }}">{{ __('website.nav.all_services') }}<small>↗</small></a>
                            <div class="nav-mega-link-grid">
                                @foreach($navServices as $navPage)
                                    <a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}<small>↗</small></a>
                                @endforeach
                            </div>
                        </section>
                    </div>
                </div>
                <div @class(['nav-cluster', 'nav-cluster-wide', 'active' => $industriesActive]) data-nav-cluster>
                    <button type="button" data-nav-cluster-button aria-expanded="false">{{ __('website.nav.industries') }}<svg viewBox="0 0 16 16"><path d="m4 6 4 4 4-4"/></svg></button>
                    <div class="nav-cluster-menu nav-mega-menu nav-mega-menu-columns nav-mega-menu-columns-2 nav-mega-menu-industries">
                        <section>
                            <span class="nav-cluster-heading">{{ __('website.nav.industries') }}</span>
                            <a class="nav-cluster-overview" href="{{ \App\Support\LocalizedUrl::path('/industries') }}">{{ __('website.nav.all_industries') }}<small>↗</small></a>
                            <div class="nav-mega-link-grid">
                                @foreach($navIndustries as $navPage)
                                    <a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}<small>↗</small></a>
                                @endforeach
                            </div>
                        </section>
                    </div>
                </div>
                <div @class(['nav-cluster', 'active' => $projectsActive]) data-nav-cluster>
                    <button type="button" data-nav-cluster-button aria-expanded="false">{{ __('website.nav.projects') }}<svg viewBox="0 0 16 16"><path d="m4 6 4 4 4-4"/></svg></button>
                    <div class="nav-cluster-menu nav-mega-menu nav-mega-menu-projects nav-mega-menu-align-right">
                        <section>
                            <span class="nav-cluster-heading">{{ __('website.nav.projects') }}</span>
                            <a class="nav-cluster-overview" href="{{ \App\Support\LocalizedUrl::path('/projects') }}">{{ __('website.nav.projects') }}<small>↗</small></a>
                            <a href="{{ \App\Support\LocalizedUrl::path('/case-studies') }}">{{ __('website.nav.case_studies') }}<small>↗</small></a>
                        </section>
                        <section>
                            <span class="nav-cluster-heading">{{ __('website.nav.products') }}</span>
                            <a class="nav-cluster-overview" href="{{ \App\Support\LocalizedUrl::path('/products') }}">{{ __('website.nav.all_products') }}<small>↗</small></a>
                            @foreach($navProducts as $navPage)
                                <a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}<small>↗</small></a>
                            @endforeach
                        </section>
                    </div>
                </div>
                <a href="{{ \App\Support\LocalizedUrl::path('/pricing') }}" @class(['active' => $pricingActive])>{{ __('website.nav.pricing') }}</a>
                <div @class(['nav-cluster', 'active' => $companyActive]) data-nav-cluster>
                    <button type="button" data-nav-cluster-button aria-expanded="false">{{ __('website.nav.company') }}<svg viewBox="0 0 16 16"><path d="m4 6 4 4 4-4"/></svg></button>
                    <div class="nav-cluster-menu nav-mega-menu nav-mega-menu-company nav-mega-menu-align-right">
                        <section>
                            <span class="nav-cluster-heading">{{ __('website.nav.company') }}</span>
                            <a class="nav-cluster-overview" href="{{ \App\Support\LocalizedUrl::path('/about') }}">{{ __('website.nav.about') }}<small>↗</small></a>
                            <a class="nav-cluster-overview" href="{{ \App\Support\LocalizedUrl::path('/articles') }}">{{ __('website.nav.all_articles') }}<small>↗</small></a>
                            @foreach($navArticles as $navPage)
                                <a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}<small>↗</small></a>
                            @endforeach
                        </section>
                    </div>
                </div>
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
                    <button type="button" class="language-button" data-language-button aria-expanded="false" aria-label="{{ __('website.accessibility.change_language') }}">
                        <span class="language-signal"></span>
                        <b>{{ strtoupper($locale) }}</b>
                        <svg viewBox="0 0 16 16" aria-hidden="true"><path d="m4 6 4 4 4-4"/></svg>
                    </button>
                    <div class="language-menu" data-language-menu>
                        @foreach(config('website.locales') as $code => $language)
                            <a href="{{ \App\Support\LocalizedUrl::current($code) }}" @class(['active' => $code === $locale]) hreflang="{{ $language['hreflang'] ?? $code }}">
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

        <nav class="mobile-nav" data-mobile-nav aria-label="{{ __('website.accessibility.mobile_navigation') }}">
            <div class="mobile-nav-priority">
                <a href="{{ \App\Support\LocalizedUrl::path('/projects') }}">{{ __('website.nav.projects') }}</a>
                <a href="{{ \App\Support\LocalizedUrl::path('/pricing') }}">{{ __('website.nav.pricing') }}</a>
                <a href="{{ \App\Support\LocalizedUrl::path('/contact') }}">{{ __('website.nav.contact') }}</a>
            </div>
            <details class="mobile-nav-group">
                <summary>{{ __('website.nav.solutions') }}<i>+</i></summary>
                <div>
                    <a href="{{ \App\Support\LocalizedUrl::path('/solutions') }}">{{ __('website.nav.all_solutions') }}</a>
                    @foreach($navSolutions as $navPage)<a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}</a>@endforeach
                </div>
            </details>
            <details class="mobile-nav-group">
                <summary>{{ __('website.nav.industries') }}<i>+</i></summary>
                <div>
                    <a href="{{ \App\Support\LocalizedUrl::path('/industries') }}">{{ __('website.nav.all_industries') }}</a>
                    @foreach($navIndustries as $navPage)<a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}</a>@endforeach
                </div>
            </details>
            <details class="mobile-nav-group">
                <summary>{{ __('website.nav.services') }}<i>+</i></summary>
                <div>
                    <a href="{{ \App\Support\LocalizedUrl::path('/services') }}">{{ __('website.nav.all_services') }}</a>
                    @foreach($navServices as $navPage)<a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}</a>@endforeach
                </div>
            </details>
            <details class="mobile-nav-group">
                <summary>{{ __('website.nav.products') }}<i>+</i></summary>
                <div>
                    <a href="{{ \App\Support\LocalizedUrl::path('/case-studies') }}">{{ __('website.nav.case_studies') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/products') }}">{{ __('website.nav.all_products') }}</a>
                    @foreach($navProducts as $navPage)<a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}</a>@endforeach
                </div>
            </details>
            <details class="mobile-nav-group">
                <summary>{{ __('website.nav.articles') }}<i>+</i></summary>
                <div>
                    <a href="{{ \App\Support\LocalizedUrl::path('/articles') }}">{{ __('website.nav.all_articles') }}</a>
                    @foreach($navArticles as $navPage)<a href="{{ \App\Support\LocalizedUrl::path('/'.$navPage->slug) }}">{{ $navPage->translation('title') }}</a>@endforeach
                </div>
            </details>
            <a href="{{ \App\Support\LocalizedUrl::path('/about') }}">{{ __('website.nav.company') }}</a>
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

    @php
        $floatingWhatsapp = preg_replace('/\D+/', '', (string) config('website.whatsapp'));
        $whatsappPageTitle = trim((string) ($seo['title'] ?? config('website.name')));
        $whatsappPageUrl = (string) ($seo['canonical'] ?? url()->current());
        $whatsappMessage = match ($locale) {
            'fa' => "سلام، من از وب‌سایت Fida Technologies پیام می‌دهم. به این صفحه علاقه‌مند هستم: {$whatsappPageTitle}\n{$whatsappPageUrl}",
            'ps' => "سلام، زه د Fida Technologies له وېب‌سایټ څخه پیغام درکوم. زه د دې پاڼې په اړه علاقه لرم: {$whatsappPageTitle}\n{$whatsappPageUrl}",
            default => "Hello, I came from the Fida Technologies website. I’m interested in this page: {$whatsappPageTitle}\n{$whatsappPageUrl}",
        };
        $whatsappUrl = 'https://wa.me/'.$floatingWhatsapp.'?text='.rawurlencode($whatsappMessage);
    @endphp
    @if($floatingWhatsapp)
        <a
            class="floating-whatsapp"
            href="{{ $whatsappUrl }}"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Chat with {{ config('website.name') }} on WhatsApp"
            title="WhatsApp"
            data-track-event="whatsapp_click"
            data-track-label="floating_whatsapp"
        >
            <svg viewBox="0 0 32 32" aria-hidden="true">
                <path d="M16.04 4.2a11.55 11.55 0 0 0-9.82 17.63L4.7 27.4l5.7-1.5a11.57 11.57 0 1 0 5.64-21.7Zm0 20.98c-1.75 0-3.47-.47-4.96-1.36l-.35-.2-3.38.88.9-3.3-.23-.34a9.43 9.43 0 1 1 8.02 4.32Zm5.17-7.06c-.28-.14-1.66-.82-1.92-.91-.26-.1-.45-.14-.64.14-.19.28-.73.91-.9 1.1-.16.19-.33.21-.61.07-.28-.14-1.19-.44-2.27-1.4a8.52 8.52 0 0 1-1.57-1.95c-.16-.28-.02-.43.12-.57.13-.13.28-.33.42-.5.14-.16.19-.28.28-.47.1-.19.05-.35-.02-.5-.07-.14-.64-1.54-.87-2.1-.23-.56-.47-.48-.64-.49h-.55c-.19 0-.5.07-.76.35-.26.28-1 1-1 2.44s1.03 2.83 1.17 3.02c.14.19 2.03 3.1 4.92 4.35.69.3 1.22.47 1.64.6.69.22 1.32.19 1.82.12.56-.08 1.66-.68 1.9-1.34.23-.65.23-1.21.16-1.33-.07-.12-.26-.19-.54-.33Z" fill="currentColor"/>
            </svg>
            <span>WhatsApp</span>
        </a>
    @endif

</body>
</html>
