@php
    use App\Support\LocalizedUrl;
    use App\Support\ModernIcons;
    use App\Support\ModernNav;

    $split = ModernNav::splitSolutions($navSolutions);
    $coreSlugs = config('website.modern.core_solution_slugs', []);
    $coreSolutions = $split['software']->filter(fn ($page) => in_array($page->slug, $coreSlugs, true))
        ->sortBy(fn ($page) => array_search($page->slug, $coreSlugs, true))->values();
    $moreSolutions = $split['software']->reject(fn ($page) => in_array($page->slug, $coreSlugs, true))->values();
    $infrastructureSlugs = config('website.modern.infrastructure_slugs', []);
    $onInfrastructure = in_array($currentSlug, $infrastructureSlugs, true);
    $locales = config('website.locales');
    $currentLocale = app()->getLocale();
    $productConfig = config('website.products', []);
    $systems = config('website.portfolio_systems', []);
    $academyIcons = config('website.modern.academy_icons', []);
    $trainingUrl = LocalizedUrl::path('/contact').'?request=training';
@endphp
<header class="mx-header">
    <div class="mx-header-bar">
        <a class="mx-brand" href="{{ LocalizedUrl::path('/') }}" aria-label="{{ config('website.name') }}">
            @include('marketing.templates.modern.partials.logo', ['uid' => 'header', 'height' => 28])
            <span><strong>{{ config('website.branding.name', 'Fida') }}</strong> Technologies</span>
        </a>

        <input type="checkbox" id="mx-nav-toggle" class="mx-nav-toggle" aria-label="{{ __('modern.nav.menu') }}" aria-controls="mx-nav">
        <label for="mx-nav-toggle" class="mx-nav-button" aria-hidden="true">
            <span></span><span></span><span></span>
        </label>

        <nav class="mx-nav" id="mx-nav" aria-label="{{ __('modern.nav.primary') }}">
            {{-- Software --}}
            <details class="mx-menu mx-mega-menu" @if(($solutionsActive && ! $onInfrastructure) || $servicesActive) data-active @endif>
                <summary>{{ __('modern.nav.software') }}</summary>
                <div class="mx-mega">
                    <div class="mx-mega-body">
                        @include('layouts.partials.modern-mega-intro', ['key' => 'software', 'href' => LocalizedUrl::path('/solutions')])
                        <div class="mx-mega-main mx-mega-software">
                            <section class="mx-mega-group mx-mega-full">
                                <p class="mx-mega-heading">{{ __('modern.menu.core') }}</p>
                                <ul class="mx-grid mx-grid-3">
                                    @foreach($coreSolutions as $navPage)
                                        @include('layouts.partials.modern-mega-item', ['href' => LocalizedUrl::path('/'.$navPage->slug), 'title' => ModernNav::label($navPage->translation('title')), 'description' => ModernNav::menuDescription($navPage), 'icon' => ModernIcons::forSlug($navPage->slug), 'current' => $currentSlug === $navPage->slug, 'variant' => 'rich'])
                                    @endforeach
                                </ul>
                            </section>
                            <section class="mx-mega-group">
                                <p class="mx-mega-heading">{{ __('modern.menu.more_solutions') }}</p>
                                <ul class="mx-grid mx-grid-2 mx-grid-tight mx-grid-dots">
                                    @foreach($moreSolutions as $navPage)
                                        @include('layouts.partials.modern-mega-item', ['href' => LocalizedUrl::path('/'.$navPage->slug), 'title' => ModernNav::label($navPage->translation('title')), 'current' => $currentSlug === $navPage->slug, 'variant' => 'compact'])
                                    @endforeach
                                </ul>
                            </section>
                            <section class="mx-mega-group mx-mega-side">
                                <p class="mx-mega-heading">{{ __('modern.menu.services') }}</p>
                                <ul class="mx-grid mx-grid-tight mx-grid-dots">
                                    @foreach($navServices as $navPage)
                                        @include('layouts.partials.modern-mega-item', ['href' => LocalizedUrl::path('/'.$navPage->slug), 'title' => ModernNav::label($navPage->translation('title')), 'current' => $currentSlug === $navPage->slug, 'variant' => 'compact'])
                                    @endforeach
                                </ul>
                            </section>
                        </div>
                    </div>
                    @include('layouts.partials.modern-mega-foot', ['allHref' => LocalizedUrl::path('/services'), 'allLabel' => __('modern.nav.all_services')])
                </div>
            </details>

            {{-- Products --}}
            <details class="mx-menu mx-mega-menu" @if($productsActive) data-active @endif>
                <summary>{{ __('modern.nav.products') }}</summary>
                <div class="mx-mega">
                    <div class="mx-mega-body">
                        @include('layouts.partials.modern-mega-intro', ['key' => 'products', 'href' => LocalizedUrl::path('/products')])
                        <div class="mx-mega-main mx-mega-products">
                            <section class="mx-mega-group">
                                <p class="mx-mega-heading">{{ __('modern.menu.flagship') }}</p>
                                <ul class="mx-grid">
                                    @foreach($productConfig as $product)
                                        @php($productName = __("website.products.{$product['key']}.name"))
                                        <li>
                                            <a class="mx-item mx-item-rich mx-item-product" href="{{ LocalizedUrl::path($product['url']) }}" @if($currentSlug === ltrim($product['url'], '/')) aria-current="page" @endif>
                                                <span class="mx-item-mono" aria-hidden="true">{{ mb_substr(ModernNav::productShortName($productName), 0, 1) }}</span>
                                                <span class="mx-item-text">
                                                    <span class="mx-item-title">{{ ModernNav::productShortName($productName) }}</span>
                                                    <span class="mx-item-desc">{{ __("website.products.{$product['key']}.description") }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </section>
                            <section class="mx-mega-group mx-mega-side">
                                <p class="mx-mega-heading">{{ __('modern.menu.systems') }}</p>
                                <ul class="mx-grid mx-grid-2 mx-grid-tight mx-grid-dots">
                                    @foreach($systems as $system)
                                        @include('layouts.partials.modern-mega-item', ['href' => LocalizedUrl::path('/products').'#system-'.$system['slug'], 'title' => ModernNav::systemName($system), 'variant' => 'compact'])
                                    @endforeach
                                </ul>
                            </section>
                        </div>
                    </div>
                    @include('layouts.partials.modern-mega-foot', ['allHref' => LocalizedUrl::path('/products'), 'allLabel' => __('modern.nav.all_products')])
                </div>
            </details>

            {{-- Infrastructure --}}
            <details class="mx-menu mx-mega-menu" @if($onInfrastructure) data-active @endif>
                <summary>{{ __('modern.nav.infrastructure') }}</summary>
                <div class="mx-mega">
                    <div class="mx-mega-body">
                        @include('layouts.partials.modern-mega-intro', ['key' => 'infrastructure', 'href' => LocalizedUrl::path('/contact').'?interest=infrastructure#contact'])
                        <div class="mx-mega-main">
                            <section class="mx-mega-group">
                                <p class="mx-mega-heading mx-mega-heading-solo">{{ __('modern.nav.infrastructure') }}</p>
                                <ul class="mx-grid mx-grid-2">
                                    @foreach($split['infrastructure'] as $navPage)
                                        @include('layouts.partials.modern-mega-item', ['href' => LocalizedUrl::path('/'.$navPage->slug), 'title' => ModernNav::label($navPage->translation('title')), 'description' => ModernNav::menuDescription($navPage), 'icon' => ModernIcons::forSlug($navPage->slug), 'current' => $currentSlug === $navPage->slug, 'variant' => 'rich'])
                                    @endforeach
                                </ul>
                            </section>
                        </div>
                    </div>
                    @include('layouts.partials.modern-mega-foot', [])
                </div>
            </details>

            {{-- Industries --}}
            <details class="mx-menu mx-mega-menu" @if($industriesActive) data-active @endif>
                <summary>{{ __('modern.nav.industries') }}</summary>
                <div class="mx-mega">
                    <div class="mx-mega-body">
                        @include('layouts.partials.modern-mega-intro', ['key' => 'industries', 'href' => LocalizedUrl::path('/industries')])
                        <div class="mx-mega-main">
                            <section class="mx-mega-group">
                                <p class="mx-mega-heading mx-mega-heading-solo">{{ __('modern.nav.industries') }}</p>
                                <ul class="mx-grid mx-grid-3 mx-grid-tiles">
                                    @foreach($navIndustries as $navPage)
                                        @include('layouts.partials.modern-mega-item', ['href' => LocalizedUrl::path('/'.$navPage->slug), 'title' => ModernNav::industryShortName($navPage->translation('title')), 'icon' => ModernIcons::forSlug($navPage->slug), 'current' => $currentSlug === $navPage->slug, 'variant' => 'compact'])
                                    @endforeach
                                </ul>
                            </section>
                        </div>
                    </div>
                    @include('layouts.partials.modern-mega-foot', ['allHref' => LocalizedUrl::path('/industries'), 'allLabel' => __('modern.nav.all_industries')])
                </div>
            </details>

            {{-- Academy --}}
            <details class="mx-menu mx-mega-menu">
                <summary>{{ __('modern.nav.academy') }}</summary>
                <div class="mx-mega">
                    <div class="mx-mega-body">
                        @include('layouts.partials.modern-mega-intro', ['key' => 'academy', 'href' => $trainingUrl.'#contact'])
                        <div class="mx-mega-main mx-mega-academy">
                            <section class="mx-mega-group">
                                <p class="mx-mega-heading">{{ __('modern.menu.tracks') }}</p>
                                <ul class="mx-grid mx-grid-2">
                                    @foreach(config('website.modern.academy_tracks', []) as $track)
                                        @include('layouts.partials.modern-mega-item', ['href' => $trainingUrl.'&interest=academy-'.$track.'#contact', 'title' => __("modern.academy.tracks.{$track}.title"), 'description' => __("modern.academy.tracks.{$track}.description"), 'icon' => $academyIcons[$track] ?? 'cap', 'variant' => 'rich', 'track' => 'academy_'.$track])
                                    @endforeach
                                </ul>
                            </section>
                            <section class="mx-mega-group mx-mega-side">
                                <p class="mx-mega-heading">{{ __('modern.nav.academy') }}</p>
                                <ul class="mx-grid mx-mega-cards">
                                    @include('layouts.partials.modern-mega-item', ['href' => $trainingUrl.'&interest=academy-organizations#contact', 'title' => __('modern.menu.for_teams'), 'description' => __('modern.menu.for_teams_text'), 'icon' => 'users', 'variant' => 'rich'])
                                    @include('layouts.partials.modern-mega-item', ['href' => $trainingUrl.'&interest=academy-teach#contact', 'title' => __('modern.menu.teach'), 'description' => __('modern.menu.teach_text'), 'icon' => 'cap', 'variant' => 'rich'])
                                </ul>
                            </section>
                        </div>
                    </div>
                    @include('layouts.partials.modern-mega-foot', [])
                </div>
            </details>

            {{-- Company --}}
            <details class="mx-menu mx-mega-menu" @if($companyActive || $pricingActive || $projectsActive) data-active @endif>
                <summary>{{ __('modern.nav.company') }}</summary>
                <div class="mx-mega">
                    <div class="mx-mega-body">
                        @include('layouts.partials.modern-mega-intro', ['key' => 'company', 'href' => LocalizedUrl::path('/about')])
                        <div class="mx-mega-main">
                            <section class="mx-mega-group">
                                <p class="mx-mega-heading mx-mega-heading-solo">{{ __('modern.nav.company') }}</p>
                                <ul class="mx-grid mx-grid-2">
                                    @foreach([
                                        ['/about', 'about', 'info'],
                                        ['/projects', 'projects', 'folder'],
                                        ['/pricing', 'pricing', 'tag'],
                                        ['/articles', 'articles', 'news'],
                                        ['/company-facts', 'facts', 'chart'],
                                        ['/software-answers-afghanistan', 'answers', 'help'],
                                        ['/request-for-quotation', 'rfq', 'clipboard'],
                                        ['/contact', 'contact', 'mail'],
                                    ] as [$path, $key, $icon])
                                        @include('layouts.partials.modern-mega-item', ['href' => LocalizedUrl::path($path), 'title' => __("modern.nav.{$key}"), 'description' => __("modern.menu.desc.{$key}"), 'icon' => $icon, 'current' => $currentSlug === ltrim($path, '/'), 'variant' => 'rich'])
                                    @endforeach
                                </ul>
                            </section>
                        </div>
                    </div>
                    @include('layouts.partials.modern-mega-foot', [])
                </div>
            </details>

            <div class="mx-nav-tools">
                <a class="mx-icon-link" href="{{ LocalizedUrl::path('/search') }}" aria-label="{{ __('modern.nav.search') }}">
                    <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><circle cx="11" cy="11" r="6.5"/><path d="m16 16 4.5 4.5"/></svg>
                </a>
                <details class="mx-menu mx-lang">
                    <summary aria-label="{{ __('modern.nav.language') }}">{{ $currentLocale === 'en' ? 'EN' : ($locales[$currentLocale]['native'] ?? strtoupper($currentLocale)) }}</summary>
                    <div class="mx-panel mx-panel-end">
                        <ul class="mx-links">
                            @foreach($locales as $code => $language)
                                <li><a href="{{ LocalizedUrl::current($code) }}" hreflang="{{ $language['hreflang'] ?? $code }}" lang="{{ $code }}" @if($code === $currentLocale) aria-current="true" @endif>{{ $language['native'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </details>
                <a class="mx-button mx-button-primary" href="{{ LocalizedUrl::path('/contact') }}#contact" data-track-event="cta_click" data-track-label="modern_header_proposal">{{ __('modern.nav.cta') }}</a>
            </div>
        </nav>
    </div>
</header>
<script>
    // Mega-menu behaviour. Menus are <details> elements, so they still open and close without this script.
    // Adds: one menu open at a time, close on outside click or Escape, and open on hover for mouse users on wide screens.
    (() => {
        const menus = () => document.querySelectorAll('.mx-menu');
        const hoverQuery = window.matchMedia('(hover: hover) and (pointer: fine) and (min-width: 1181px)');
        let closeTimer;
        let openedByHoverAt = 0;

        document.addEventListener('toggle', (event) => {
            const menu = event.target;
            if (!(menu instanceof HTMLDetailsElement) || !menu.classList.contains('mx-menu') || !menu.open) return;
            menus().forEach((other) => { if (other !== menu && !other.contains(menu)) other.open = false; });
        }, true);

        document.addEventListener('click', (event) => {
            const summary = event.target.closest('.mx-mega-menu > summary');
            // A click right after hover-opening would otherwise close the menu the visitor is reaching for.
            if (summary && summary.parentElement.open && Date.now() - openedByHoverAt < 500) {
                event.preventDefault();
                return;
            }
            if (event.target.closest('.mx-menu')) return;
            menus().forEach((menu) => { menu.open = false; });
        });

        document.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') return;
            menus().forEach((menu) => {
                if (menu.open) { menu.open = false; menu.querySelector('summary')?.focus(); }
            });
        });

        document.querySelectorAll('.mx-mega-menu').forEach((menu) => {
            menu.addEventListener('mouseenter', () => {
                if (!hoverQuery.matches) return;
                clearTimeout(closeTimer);
                if (!menu.open) { menu.open = true; openedByHoverAt = Date.now(); }
            });
            menu.addEventListener('mouseleave', () => {
                if (!hoverQuery.matches) return;
                clearTimeout(closeTimer);
                closeTimer = setTimeout(() => { menu.open = false; }, 180);
            });
        });
    })();
</script>
