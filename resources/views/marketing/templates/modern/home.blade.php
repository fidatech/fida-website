@extends('layouts.marketing')

@php
    use App\Support\LocalizedUrl;
    use App\Support\ModernNav;

    $currentLocale = app()->getLocale();
    $otherLocales = collect(config('website.locales'))->except($currentLocale);
    $systems = config('website.portfolio_systems', []);
    $tracks = config('website.modern.academy_tracks', []);
    $trainingUrl = fn (string $interest) => LocalizedUrl::path('/contact').'?request=training&interest='.$interest.'#contact';

    $pillars = [
        'software' => [
            'links' => $solutionPages['software']->take(5)->map(fn ($p) => [LocalizedUrl::path('/'.$p->slug), ModernNav::label($p->translation('title'))]),
            'all' => LocalizedUrl::path('/solutions'),
        ],
        'products' => [
            'links' => collect($products)->map(fn ($p) => [LocalizedUrl::path($p['url']), __("website.products.{$p['key']}.name")]),
            'all' => LocalizedUrl::path('/products'),
        ],
        'infrastructure' => [
            'links' => $solutionPages['infrastructure']->take(5)->map(fn ($p) => [LocalizedUrl::path('/'.$p->slug), ModernNav::label($p->translation('title'))]),
            'all' => LocalizedUrl::path('/solutions'),
        ],
        'industries' => [
            'links' => $industryPages->take(6)->map(fn ($p) => [LocalizedUrl::path('/'.$p->slug), ModernNav::label($p->translation('title'))]),
            'all' => LocalizedUrl::path('/industries'),
        ],
        'academy' => [
            'links' => collect($tracks)->map(fn ($t) => [$trainingUrl('academy-'.$t), __("modern.academy.tracks.{$t}.title")]),
            'all' => $trainingUrl('academy'),
        ],
    ];

    // Stars in the hero lattice that carry colour: [column, row, tone].
    $litStars = [[1, 0, 'saffron'], [3, 1, 'turquoise'], [0, 2, 'turquoise'], [2, 3, 'saffron'], [4, 3, 'sky'], [1, 4, 'sky']];
    $star = '100,50 85.36,64.64 85.36,85.36 64.64,85.36 50,100 35.36,85.36 14.64,85.36 14.64,64.64 0,50 14.64,35.36 14.64,14.64 35.36,14.64 50,0 64.64,14.64 85.36,14.64 85.36,35.36';
@endphp

@section('content')
<section class="mx-hero">
    <div class="mx-wrap mx-hero-grid">
        <div class="mx-hero-copy">
            <h1>{{ __('modern.hero.title') }}</h1>
            <div class="mx-hero-translations">
                @foreach($otherLocales as $code => $language)
                    <p lang="{{ $code }}" dir="{{ $language['direction'] }}">{{ trans('modern.hero.title', [], $code) }}</p>
                @endforeach
            </div>
            <p class="mx-hero-lead">{{ __('modern.hero.lead') }}</p>
            <div class="mx-actions">
                <a class="mx-button mx-button-saffron" href="{{ LocalizedUrl::path('/contact') }}#contact" data-track-event="cta_click" data-track-label="modern_hero_proposal">{{ __('modern.hero.primary') }}</a>
                <a class="mx-button mx-button-ghost" href="{{ LocalizedUrl::path('/products') }}" data-track-event="cta_click" data-track-label="modern_hero_products">{{ __('modern.hero.secondary') }}</a>
            </div>
        </div>
        <figure class="mx-lattice" aria-hidden="true">
            <svg viewBox="0 0 500 500" role="img" focusable="false">
                <title>{{ __('modern.hero.lattice') }}</title>
                <defs>
                    <pattern id="mx-khatam" width="100" height="100" patternUnits="userSpaceOnUse">
                        <polygon points="{{ $star }}" class="mx-lattice-line"/>
                        <rect x="35.36" y="35.36" width="29.28" height="29.28" transform="rotate(45 50 50)" class="mx-lattice-line"/>
                    </pattern>
                </defs>
                <rect width="500" height="500" fill="url(#mx-khatam)"/>
                @foreach($litStars as [$column, $row, $tone])
                    <polygon points="{{ $star }}" transform="translate({{ $column * 100 }} {{ $row * 100 }})" class="mx-lattice-star mx-tone-{{ $tone }}"/>
                @endforeach
            </svg>
        </figure>
    </div>
    <div class="mx-wrap">
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
            <h2>{{ __('modern.pillars.title') }}</h2>
            <p>{{ __('modern.pillars.intro') }}</p>
        </header>
        <div class="mx-pillars">
            @foreach($pillars as $key => $pillar)
                <article class="mx-pillar" id="pillar-{{ $key }}">
                    <div class="mx-pillar-intro">
                        <h3>{{ __("modern.pillars.{$key}.title") }}</h3>
                        <p>{{ __("modern.pillars.{$key}.description") }}</p>
                    </div>
                    <ul class="mx-pillar-links">
                        @foreach($pillar['links'] as [$url, $label])
                            <li><a href="{{ $url }}">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                    <a class="mx-pillar-all" href="{{ $pillar['all'] }}" aria-label="{{ __('modern.pillars.see_all') }}: {{ __("modern.pillars.{$key}.title") }}">{{ __('modern.pillars.see_all') }}</a>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="mx-section mx-section-tinted" id="products">
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
                    <span role="cell" class="mx-catalog-name">{{ __("website.products.{$product['key']}.name") }}</span>
                    <span role="cell">{{ __("website.products.{$product['key']}.description") }}</span>
                </a>
            @endforeach
            @foreach(array_slice($systems, 0, 8) as $system)
                <a class="mx-catalog-row" role="row" href="{{ LocalizedUrl::path('/products') }}#system-{{ $system['slug'] }}">
                    <span role="cell" class="mx-catalog-name">{{ $system['name'] }}</span>
                    <span role="cell">{{ ModernNav::systemDescription($system) }}</span>
                </a>
            @endforeach
        </div>
        <div class="mx-actions">
            <a class="mx-button mx-button-lapis" href="{{ LocalizedUrl::path('/products') }}">{{ __('modern.products.all') }}</a>
            <a class="mx-button mx-button-outline" href="{{ LocalizedUrl::path('/contact') }}?request=erp#contact">{{ __('modern.products.demo') }}</a>
        </div>
    </div>
</section>

<section class="mx-section mx-academy" id="academy">
    <div class="mx-wrap mx-academy-grid">
        <div class="mx-academy-copy">
            <h2>{{ __('modern.academy.title') }}</h2>
            <p class="mx-academy-lead">{{ __('modern.academy.lead') }}</p>
            <div class="mx-academy-teams">
                <h3>{{ __('modern.academy.teams_title') }}</h3>
                <p>{{ __('modern.academy.teams_description') }}</p>
                <a class="mx-button mx-button-saffron" href="{{ $trainingUrl('academy-organizations') }}" data-track-event="cta_click" data-track-label="modern_academy_teams">{{ __('modern.academy.cta_team') }}</a>
            </div>
        </div>
        <ul class="mx-tracks" aria-label="{{ __('modern.academy.tracks_label') }}">
            @foreach($tracks as $track)
                <li>
                    <a href="{{ $trainingUrl('academy-'.$track) }}">
                        <h3>{{ __("modern.academy.tracks.{$track}.title") }}</h3>
                        <p>{{ __("modern.academy.tracks.{$track}.description") }}</p>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</section>

<section class="mx-section" id="process">
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
