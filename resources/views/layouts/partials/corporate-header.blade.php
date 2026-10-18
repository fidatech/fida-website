<header class="site-header corporate-header" data-header>
    <div class="container corp-nav-shell">
        <a class="corp-brand" href="{{ \App\Support\LocalizedUrl::path('/') }}" aria-label="{{ config('website.name') }}">
            @if(config('website.branding.logo_url'))
                <img src="{{ config('website.branding.logo_url') }}" width="44" height="44" alt="{{ config('website.name') }} logo">
            @else
                <span class="corp-brand-mark">F</span>
            @endif
            <span><strong>{{ config('website.branding.name') }}</strong><small>{{ config('website.branding.tagline') }}</small></span>
        </a>
        <nav class="corp-desktop-nav" aria-label="{{ __('website.accessibility.primary_navigation') }}">
            <a href="{{ \App\Support\LocalizedUrl::path('/solutions') }}">{{ __('website.nav.solutions') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/services') }}">{{ __('website.nav.services') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/products') }}">{{ __('website.nav.products') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/industries') }}">{{ __('website.nav.industries') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/pricing') }}">{{ __('website.nav.pricing') }}</a>
            <a href="{{ \App\Support\LocalizedUrl::path('/about') }}">{{ __('website.nav.about') }}</a>
        </nav>
        <div class="corp-nav-actions">
            <details class="corp-lang">
                <summary>{{ strtoupper($locale) }} <span aria-hidden="true">⌄</span></summary>
                <div class="corp-lang-menu">
                    @foreach(config('website.locales') as $code => $language)
                        <a lang="{{ $code }}" href="{{ \App\Support\LocalizedUrl::current($code) }}">{{ $language['native'] }}</a>
                    @endforeach
                </div>
            </details>
            <a class="corp-nav-cta" href="{{ \App\Support\LocalizedUrl::path('/contact') }}">{{ __('website.nav.contact') }} <span aria-hidden="true">↗</span></a>
            <details class="corp-mobile-menu">
                <summary aria-label="Open navigation"><span></span><span></span><span></span></summary>
                <nav aria-label="{{ __('website.accessibility.primary_navigation') }}">
                    <a href="{{ \App\Support\LocalizedUrl::path('/') }}">{{ __('website.page.home') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/solutions') }}">{{ __('website.nav.solutions') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/services') }}">{{ __('website.nav.services') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/products') }}">{{ __('website.nav.products') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/industries') }}">{{ __('website.nav.industries') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/pricing') }}">{{ __('website.nav.pricing') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/about') }}">{{ __('website.nav.about') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/contact') }}">{{ __('website.nav.contact') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/search') }}">{{ __('website.nav.search') }}</a>
                </nav>
            </details>
        </div>
    </div>
</header>