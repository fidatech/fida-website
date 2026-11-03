@php
    use App\Support\LocalizedUrl;
    use App\Support\ModernNav;

    $split = ModernNav::splitSolutions($navSolutions);
    $locales = config('website.locales');
    $currentLocale = app()->getLocale();
    $productConfig = config('website.products', []);
    $systems = config('website.portfolio_systems', []);
@endphp
<header class="mx-header">
    <div class="mx-wrap mx-header-bar">
        <a class="mx-brand" href="{{ LocalizedUrl::path('/') }}" aria-label="{{ config('website.name') }}">
            @if(config('website.branding.logo_url'))
                <img src="{{ config('website.branding.logo_url') }}" alt="" width="36" height="36">
            @else
                <svg viewBox="0 0 36 36" width="36" height="36" aria-hidden="true"><rect width="36" height="36" rx="8" fill="var(--mx-lapis)"/><path d="M10 8h17v5H15.5v4.5h9.5v5h-9.5V28H10z" fill="#fff"/><path d="M23 23h5v5h-5z" fill="var(--mx-saffron)"/></svg>
            @endif
            <span><strong>{{ config('website.branding.name', 'Fida') }}</strong> Technologies</span>
        </a>

        <input type="checkbox" id="mx-nav-toggle" class="mx-nav-toggle" aria-label="{{ __('modern.nav.menu') }}" aria-controls="mx-nav">
        <label for="mx-nav-toggle" class="mx-nav-button" aria-hidden="true">
            <span></span><span></span><span></span>
        </label>

        <nav class="mx-nav" id="mx-nav" aria-label="{{ __('modern.nav.primary') }}">
            <details class="mx-menu" @if($solutionsActive || $servicesActive) data-active @endif>
                <summary>{{ __('modern.nav.software') }}</summary>
                <div class="mx-panel mx-panel-wide">
                    <div>
                        <p class="mx-panel-heading">{{ __('modern.nav.solutions') }}</p>
                        <ul class="mx-links mx-links-columns">
                            @foreach($split['software'] as $navPage)
                                <li><a href="{{ LocalizedUrl::path('/'.$navPage->slug) }}">{{ ModernNav::label($navPage->translation('title')) }}</a></li>
                            @endforeach
                        </ul>
                        <a class="mx-panel-all" href="{{ LocalizedUrl::path('/solutions') }}">{{ __('modern.nav.all_solutions') }}</a>
                    </div>
                    <div>
                        <p class="mx-panel-heading">{{ __('modern.nav.services') }}</p>
                        <ul class="mx-links">
                            @foreach($navServices as $navPage)
                                <li><a href="{{ LocalizedUrl::path('/'.$navPage->slug) }}">{{ ModernNav::label($navPage->translation('title')) }}</a></li>
                            @endforeach
                        </ul>
                        <a class="mx-panel-all" href="{{ LocalizedUrl::path('/services') }}">{{ __('modern.nav.all_services') }}</a>
                    </div>
                </div>
            </details>

            <details class="mx-menu" @if($productsActive) data-active @endif>
                <summary>{{ __('modern.nav.products') }}</summary>
                <div class="mx-panel mx-panel-wide">
                    <div>
                        <p class="mx-panel-heading">{{ __('modern.nav.flagship') }}</p>
                        <ul class="mx-links">
                            @foreach($productConfig as $product)
                                <li><a href="{{ LocalizedUrl::path($product['url']) }}">{{ __("website.products.{$product['key']}.name") }}</a></li>
                            @endforeach
                        </ul>
                        <a class="mx-panel-all" href="{{ LocalizedUrl::path('/products') }}">{{ __('modern.nav.all_products') }}</a>
                    </div>
                    <div>
                        <p class="mx-panel-heading">{{ __('modern.nav.more_products') }}</p>
                        <ul class="mx-links mx-links-columns">
                            @foreach($systems as $system)
                                <li><a href="{{ LocalizedUrl::path('/products') }}#system-{{ $system['slug'] }}">{{ $system['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </details>

            <details class="mx-menu" @if($solutionsActive && $routePage instanceof \App\Models\ContentPage && in_array($routePage->slug, config('website.modern.infrastructure_slugs', []), true)) data-active @endif>
                <summary>{{ __('modern.nav.infrastructure') }}</summary>
                <div class="mx-panel">
                    <ul class="mx-links">
                        @foreach($split['infrastructure'] as $navPage)
                            <li><a href="{{ LocalizedUrl::path('/'.$navPage->slug) }}">{{ ModernNav::label($navPage->translation('title')) }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </details>

            <details class="mx-menu" @if($industriesActive) data-active @endif>
                <summary>{{ __('modern.nav.industries') }}</summary>
                <div class="mx-panel mx-panel-wide">
                    <ul class="mx-links mx-links-columns">
                        @foreach($navIndustries as $navPage)
                            <li><a href="{{ LocalizedUrl::path('/'.$navPage->slug) }}">{{ ModernNav::label($navPage->translation('title')) }}</a></li>
                        @endforeach
                    </ul>
                    <a class="mx-panel-all" href="{{ LocalizedUrl::path('/industries') }}">{{ __('modern.nav.all_industries') }}</a>
                </div>
            </details>

            <details class="mx-menu">
                <summary>{{ __('modern.nav.academy') }}</summary>
                <div class="mx-panel">
                    <p class="mx-panel-heading">{{ __('modern.nav.academy_courses') }}</p>
                    <ul class="mx-links">
                        @foreach(config('website.modern.academy_tracks', []) as $track)
                            <li><a href="{{ LocalizedUrl::path('/contact') }}?request=training&amp;interest=academy-{{ $track }}#contact">{{ __("modern.academy.tracks.{$track}.title") }}</a></li>
                        @endforeach
                    </ul>
                    <a class="mx-panel-all" href="{{ LocalizedUrl::path('/contact') }}?request=training&amp;interest=academy-organizations#contact">{{ __('modern.nav.academy_teams') }}</a>
                </div>
            </details>

            <details class="mx-menu" @if($companyActive || $pricingActive || $projectsActive) data-active @endif>
                <summary>{{ __('modern.nav.company') }}</summary>
                <div class="mx-panel">
                    <ul class="mx-links">
                        <li><a href="{{ LocalizedUrl::path('/about') }}">{{ __('modern.nav.about') }}</a></li>
                        <li><a href="{{ LocalizedUrl::path('/projects') }}">{{ __('modern.nav.projects') }}</a></li>
                        <li><a href="{{ LocalizedUrl::path('/pricing') }}">{{ __('modern.nav.pricing') }}</a></li>
                        <li><a href="{{ LocalizedUrl::path('/articles') }}">{{ __('modern.nav.articles') }}</a></li>
                        <li><a href="{{ LocalizedUrl::path('/company-facts') }}">{{ __('modern.nav.facts') }}</a></li>
                        <li><a href="{{ LocalizedUrl::path('/software-answers-afghanistan') }}">{{ __('modern.nav.answers') }}</a></li>
                        <li><a href="{{ LocalizedUrl::path('/request-for-quotation') }}">{{ __('modern.nav.rfq') }}</a></li>
                        <li><a href="{{ LocalizedUrl::path('/contact') }}">{{ __('modern.nav.contact') }}</a></li>
                    </ul>
                </div>
            </details>

            <div class="mx-nav-tools">
                <a class="mx-icon-link" href="{{ LocalizedUrl::path('/search') }}" aria-label="{{ __('modern.nav.search') }}">
                    <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><circle cx="11" cy="11" r="6.5"/><path d="m16 16 4.5 4.5"/></svg>
                </a>
                <details class="mx-menu mx-lang">
                    <summary aria-label="{{ __('modern.nav.language') }}">{{ $locales[$currentLocale]['native'] ?? strtoupper($currentLocale) }}</summary>
                    <div class="mx-panel mx-panel-end">
                        <ul class="mx-links">
                            @foreach($locales as $code => $language)
                                <li><a href="{{ LocalizedUrl::current($code) }}" hreflang="{{ $language['hreflang'] ?? $code }}" lang="{{ $code }}" @if($code === $currentLocale) aria-current="true" @endif>{{ $language['native'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </details>
                <a class="mx-button mx-button-saffron" href="{{ LocalizedUrl::path('/contact') }}#contact" data-track-event="cta_click" data-track-label="modern_header_proposal">{{ __('modern.nav.cta') }}</a>
            </div>
        </nav>
    </div>
</header>
<script>
    // Keep one menu open at a time and close menus on outside click or Escape. Menus still work without this.
    (() => {
        const menus = () => document.querySelectorAll('.mx-menu');
        document.addEventListener('toggle', (event) => {
            const menu = event.target;
            if (!(menu instanceof HTMLDetailsElement) || !menu.classList.contains('mx-menu') || !menu.open) return;
            menus().forEach((other) => { if (other !== menu && !other.contains(menu)) other.open = false; });
        }, true);
        document.addEventListener('click', (event) => {
            if (event.target.closest('.mx-menu')) return;
            menus().forEach((menu) => { menu.open = false; });
        });
        document.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') return;
            menus().forEach((menu) => {
                if (menu.open) { menu.open = false; menu.querySelector('summary')?.focus(); }
            });
        });
    })();
</script>
