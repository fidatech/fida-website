@extends('layouts.marketing')

@php
    use App\Support\LocalizedUrl;
    use App\Support\ModernNav;

    $currentLocale = app()->getLocale();
    $otherLocales = collect(config('website.locales'))->except($currentLocale);
    $systems = config('website.portfolio_systems', []);
    $tracks = config('website.modern.academy_tracks', []);
    $trainingUrl = fn (string $interest) => LocalizedUrl::path('/contact').'?request=training&interest='.$interest.'#contact';
    $softwareLinks = $solutionPages['software']->take(8);
    $infrastructureLinks = $solutionPages['infrastructure']->take(4);
    $industryLinks = $industryPages->take(9);
@endphp

@section('content')
<section class="mx-hero">
    <div class="mx-wrap mx-hero-copy">
        <a class="mx-badge" href="{{ $trainingUrl('academy') }}"><b>{{ __('modern.hero.badge_tag') }}</b>{{ __('modern.hero.badge') }}</a>
        <h1>{{ __('modern.hero.title') }}</h1>
        <p class="mx-hero-translations">
            @foreach($otherLocales as $code => $language)
                <span lang="{{ $code }}" dir="{{ $language['direction'] }}">{{ trans('modern.hero.title', [], $code) }}</span>
            @endforeach
        </p>
        <p class="mx-hero-lead">{{ __('modern.hero.lead') }}</p>
        <div class="mx-actions">
            <a class="mx-button mx-button-primary" href="{{ LocalizedUrl::path('/contact') }}#contact" data-track-event="cta_click" data-track-label="modern_hero_proposal">{{ __('modern.hero.primary') }}</a>
            <a class="mx-button mx-button-light" href="{{ LocalizedUrl::path('/products') }}" data-track-event="cta_click" data-track-label="modern_hero_products">{{ __('modern.hero.secondary_count') }}</a>
        </div>
    </div>
    <div class="mx-wrap">
        @include('marketing.templates.modern.partials.product-stage')
        <dl class="mx-figures" aria-label="{{ __('modern.figures.label') }}">
            @foreach(config('website.modern.figures', []) as $figure)
                <div>
                    <dt>{{ __("modern.figures.{$figure['key']}") }}</dt>
                    <dd><bdi dir="ltr">{{ $figure['value'] }}</bdi></dd>
                </div>
            @endforeach
        </dl>
    </div>
</section>

<section class="mx-section" id="what-we-do">
    <div class="mx-wrap">
        <header class="mx-section-head">
            <h2>{{ __('modern.bento.title') }}</h2>
            <p>{{ __('modern.bento.intro') }}</p>
        </header>

        <div class="mx-bento">
            <article class="mx-tile mx-tile-software">
                <div>
                    <h3>{{ __('modern.pillars.software.title') }}</h3>
                    <p>{{ __('modern.pillars.software.description') }}</p>
                </div>
                <ul class="mx-chips mx-chips-modules">
                    @foreach(__('modern.bento.modules') as $module)
                        <li>{{ $module }}</li>
                    @endforeach
                </ul>
                <div class="mx-flow" aria-hidden="true" lang="en" dir="ltr">
                    <div><i>✓</i>Purchase request #219 · Finance<b>Approved</b></div>
                    <div><i>✓</i>Payroll · October · 142 staff<b>Posted</b></div>
                    <div><i class="wait">2</i>Stock transfer · Kabul → Mazar<b class="wait">Awaiting</b></div>
                    <div><i>✓</i>Donor report · Q3 · INGO<b>Sent</b></div>
                </div>
                <ul class="mx-tile-links">
                    @foreach($softwareLinks as $navPage)
                        <li><a href="{{ LocalizedUrl::path('/'.$navPage->slug) }}">{{ ModernNav::label($navPage->translation('title')) }}</a></li>
                    @endforeach
                </ul>
                <a class="mx-tile-cta" href="{{ LocalizedUrl::path('/solutions') }}">{{ __('modern.bento.software_cta') }}</a>
            </article>

            <article class="mx-tile mx-tile-products">
                <div>
                    <h3>{{ __('modern.bento.products_title') }}</h3>
                    <p>{{ __('modern.bento.products_description') }}</p>
                </div>
                <ul class="mx-product-grid">
                    @foreach($products as $product)
                        <li><a href="{{ LocalizedUrl::path($product['url']) }}" data-track-event="product_view" data-track-label="{{ $product['key'] }}"><b aria-hidden="true">{{ mb_strtoupper(mb_substr($product['key'], 0, 1)) }}</b>{{ ModernNav::productShortName(__("website.products.{$product['key']}.name")) }}</a></li>
                    @endforeach
                    @foreach(array_slice($systems, 0, 6) as $system)
                        <li><a href="{{ LocalizedUrl::path('/products') }}#system-{{ $system['slug'] }}"><b aria-hidden="true">{{ mb_strtoupper(mb_substr($system['name'], 0, 1)) }}</b>{{ ModernNav::systemName($system) }}</a></li>
                    @endforeach
                </ul>
                <a class="mx-tile-cta" href="{{ LocalizedUrl::path('/products') }}">{{ __('modern.bento.products_cta') }}</a>
            </article>

            <article class="mx-tile mx-tile-infra">
                <div>
                    <h3>{{ __('modern.pillars.infrastructure.title') }}</h3>
                    <p>{{ __('modern.pillars.infrastructure.description') }}</p>
                </div>
                <ul class="mx-status-list">
                    @foreach($infrastructureLinks as $navPage)
                        <li><a href="{{ LocalizedUrl::path('/'.$navPage->slug) }}"><i aria-hidden="true"></i>{{ ModernNav::label($navPage->translation('title')) }}</a></li>
                    @endforeach
                </ul>
                <a class="mx-tile-cta" href="{{ LocalizedUrl::path('/solutions') }}">{{ __('modern.bento.infrastructure_cta') }}</a>
            </article>

            <article class="mx-tile mx-tile-industries">
                <div>
                    <h3>{{ __('modern.bento.industries_title') }}</h3>
                    <p>{{ __('modern.bento.industries_description') }}</p>
                </div>
                <ul class="mx-chips">
                    @foreach($industryLinks as $navPage)
                        <li><a href="{{ LocalizedUrl::path('/'.$navPage->slug) }}">{{ ModernNav::industryShortName($navPage->translation('title')) }}</a></li>
                    @endforeach
                </ul>
                <a class="mx-tile-cta" href="{{ LocalizedUrl::path('/industries') }}">{{ __('modern.bento.industries_cta') }}</a>
            </article>

            <article class="mx-tile mx-tile-academy">
                <div>
                    <h3>{{ __('modern.academy.title') }}</h3>
                    <p>{{ __('modern.bento.academy_description') }}</p>
                </div>
                <a class="mx-course" href="{{ $trainingUrl('academy-linux') }}">
                    <span class="mx-course-head"><b>{{ __('modern.academy.tracks.linux.title') }}</b><small>{{ __('modern.bento.course_meta') }}</small></span>
                    <span class="mx-course-bar" aria-hidden="true"><i></i></span>
                    <span class="mx-course-foot"><small>{{ __('modern.bento.course_progress') }}</small><strong>{{ __('modern.bento.certificate') }}</strong></span>
                </a>
                <ul class="mx-chips mx-chips-tracks">
                    @foreach(array_diff($tracks, ['linux']) as $track)
                        <li><a href="{{ $trainingUrl('academy-'.$track) }}">{{ __("modern.academy.tracks.{$track}.title") }}</a></li>
                    @endforeach
                </ul>
                <a class="mx-tile-cta" href="#academy">{{ __('modern.bento.academy_cta') }}</a>
            </article>
        </div>
    </div>
</section>

<section class="mx-section mx-section-soft" id="products">
    <div class="mx-wrap">
        <header class="mx-section-head">
            <h2>{{ __('modern.products.title') }}</h2>
            <p>{{ __('modern.products.intro') }}</p>
        </header>
        <div class="mx-catalog" role="table" aria-label="{{ __('modern.nav.products') }}">
            <div class="mx-catalog-row mx-catalog-head" role="row">
                <span role="columnheader">{{ __('modern.products.col_name') }}</span>
                <span role="columnheader">{{ __('modern.products.col_does') }}</span>
            </div>
            @foreach($products as $product)
                <a class="mx-catalog-row mx-catalog-flagship" role="row" href="{{ LocalizedUrl::path($product['url']) }}" data-track-event="product_view" data-track-label="{{ $product['key'] }}">
                    <span role="cell" class="mx-catalog-name"><b aria-hidden="true">{{ mb_strtoupper(mb_substr($product['key'], 0, 1)) }}</b>{{ __("website.products.{$product['key']}.name") }}</span>
                    <span role="cell">{{ __("website.products.{$product['key']}.description") }}</span>
                </a>
            @endforeach
            @foreach(array_slice($systems, 0, 8) as $system)
                <a class="mx-catalog-row" role="row" href="{{ LocalizedUrl::path('/products') }}#system-{{ $system['slug'] }}">
                    <span role="cell" class="mx-catalog-name"><b aria-hidden="true">{{ mb_strtoupper(mb_substr($system['name'], 0, 1)) }}</b>{{ ModernNav::systemName($system) }}</span>
                    <span role="cell">{{ ModernNav::systemDescription($system) }}</span>
                </a>
            @endforeach
        </div>
        <div class="mx-actions mx-actions-center">
            <a class="mx-button mx-button-dark" href="{{ LocalizedUrl::path('/products') }}">{{ __('modern.products.all') }}</a>
            <a class="mx-button mx-button-light" href="{{ LocalizedUrl::path('/contact') }}?request=erp#contact">{{ __('modern.products.demo') }}</a>
        </div>
    </div>
</section>

<section class="mx-section" id="academy">
    <div class="mx-wrap mx-academy">
        <div class="mx-academy-panel">
            <h2>{{ __('modern.academy.title') }}</h2>
            <p>{{ __('modern.academy.lead') }}</p>
            <div class="mx-academy-teams">
                <h3>{{ __('modern.academy.teams_title') }}</h3>
                <p>{{ __('modern.academy.teams_description') }}</p>
                <a class="mx-button mx-button-primary" href="{{ $trainingUrl('academy-organizations') }}" data-track-event="cta_click" data-track-label="modern_academy_teams">{{ __('modern.academy.cta_team') }}</a>
            </div>
        </div>
        <ul class="mx-tracks" aria-label="{{ __('modern.academy.tracks_label') }}">
            @foreach($tracks as $track)
                <li>
                    <a href="{{ $trainingUrl('academy-'.$track) }}">
                        <h3>{{ __("modern.academy.tracks.{$track}.title") }}</h3>
                        <p>{{ __("modern.academy.tracks.{$track}.description") }}</p>
                        <span>{{ __('modern.academy.cta_course') }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</section>

<section class="mx-section mx-section-soft" id="process">
    <div class="mx-wrap">
        <header class="mx-section-head">
            <h2>{{ __('modern.process.title') }}</h2>
            <p>{{ __('website.editorial.process_intro') }}</p>
        </header>
        <ol class="mx-steps">
            @foreach(__('website.editorial.steps') as $step)
                <li>
                    <h3>{{ $step['title'] }}</h3>
                    <p>{{ $step['description'] }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>

@include('marketing.templates.modern.partials.contact')
@endsection
