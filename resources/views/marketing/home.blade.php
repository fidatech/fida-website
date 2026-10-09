@extends('layouts.marketing')

@section('content')
<section class="hero" data-hero>
    <div class="hero-grid-lines" aria-hidden="true"></div>
    <div class="hero-index" aria-hidden="true">F / 27</div>
    <div class="container hero-layout">
        <div class="hero-copy reveal">
            <div class="system-pill"><span class="system-pulse"></span>{{ __('website.hero.eyebrow') }}<b>ENTERPRISE</b></div>
            <h1>{{ __('website.hero.title_before') }} <em>{{ __('website.hero.title_emphasis') }}</em></h1>
            <p class="hero-description">{{ __('website.hero.description') }}</p>
            <div class="hero-actions">
                <a class="button button-lime button-large" href="{{ App\Support\LocalizedUrl::path('/contact') }}" data-track-event="cta_click" data-track-label="hero_primary">{{ __('website.hero.primary_cta') }}<span class="button-arrow">↗</span></a>
                <a class="button button-wire button-large" href="{{ App\Support\LocalizedUrl::path('/solutions') }}">{{ __('website.hero.secondary_cta') }}<span class="button-arrow">↗</span></a>
            </div>
            <div class="hero-proof">
                <div class="proof-stack" aria-hidden="true"><span>ERP</span><span>AF</span><span>AI</span></div>
                <p>{{ __('website.hero.trust') }}</p>
                <svg viewBox="0 0 42 12" aria-hidden="true"><path d="M1 10 8 5l7 3 8-7 8 4 10-4"/></svg>
            </div>
        </div>

        <div class="core-stage reveal" data-core-stage aria-label="{{ __('website.accessibility.technology_core') }}">
            <div class="stage-readout stage-readout-top"><span>FIDA TECHNOLOGIES</span><b>AFGHANISTAN</b></div>
            <div class="core-scene" data-core-scene>
                <div class="scene-shadow"></div>
                <div class="scene-ring scene-ring-outer"></div>
                <div class="scene-ring scene-ring-inner"></div>
                <div class="orbit orbit-one"><span class="orbit-node node-erp">ERP</span><span class="orbit-node node-ai">AI</span></div>
                <div class="orbit orbit-two"><span class="orbit-node node-data">DATA</span><span class="orbit-node node-cloud">CLOUD</span></div>

                <div class="core-cube" aria-hidden="true">
                    <div class="cube-face cube-front"><span>{{ mb_substr(config('website.branding.name'), 0, 1) }}</span><small>ENTERPRISE</small></div>
                    <div class="cube-face cube-back"><span>ERP</span></div>
                    <div class="cube-face cube-right"><i></i><i></i><i></i></div>
                    <div class="cube-face cube-left"><b>01</b><b>10</b><b>11</b></div>
                    <div class="cube-face cube-top"></div>
                    <div class="cube-face cube-bottom"></div>
                </div>

                <div class="float-panel panel-signal">
                    <div class="panel-label"><span></span>DELIVERY MODEL</div>
                    <div class="signal-value">PHASED<small>CONTROLLED</small></div>
                    <svg viewBox="0 0 124 34" preserveAspectRatio="none" aria-hidden="true"><path d="M1 27 14 21l12 4 13-16 13 10 13-6 13 9 13-17 13 7 19-9"/></svg>
                </div>
                <div class="float-panel panel-modules">
                    <div class="panel-label">INTEGRATED OPERATIONS</div>
                    <div class="module-row"><i></i><i></i><i></i><i></i><i></i></div>
                    <strong>ERP <small>CONNECTED</small></strong>
                </div>
                <div class="float-panel panel-command"><span>⌁</span><div><small>DECISION SUPPORT</small><strong>Clear operational data.</strong></div></div>
            </div>
            <div class="stage-readout stage-readout-bottom"><span>KBL · 34.55°N</span><span>SERVER RENDERED</span></div>
        </div>
    </div>

    <div class="container metric-deck reveal">
        @foreach(config('website.stats') as $stat)
            <article><span>0{{ $loop->iteration }}</span><strong>{{ $stat['value'] }}</strong><p>{{ __("website.stats.{$stat['key']}") }}</p></article>
        @endforeach
        <article class="metric-stack"><span>04</span><div><b>ERP</b><b>AI</b><b>NETWORK</b><b>INFRA</b></div><p>ENTERPRISE CAPABILITIES</p></article>
    </div>
</section>

<section class="ticker" aria-label="{{ __('website.accessibility.capabilities') }}">
    <div class="ticker-track">
        @for($i = 0; $i < 2; $i++)
            <span>ENTERPRISE SOFTWARE <b>✦</b> ERP & MIS <b>✦</b> WEB & MOBILE <b>✦</b> AI & IOT <b>✦</b> DATA CENTERS <b>✦</b> NETWORKS <b>✦</b> CYBERSECURITY <b>✦</b> HARDWARE SUPPLY <b>✦</b></span>
        @endfor
    </div>
</section>

<section class="company-proof-section">
    <div class="container company-proof-shell reveal">
        <div class="company-proof-copy">
            <div class="micro-label"><span>00</span>{{ __('website.company.eyebrow') }}</div>
            <h2>{{ __('website.company.title') }}</h2>
            <p>{{ __('website.company.description') }}</p>
            <div class="company-proof-links">
                <a href="{{ App\Support\LocalizedUrl::path('/about') }}">{{ __('website.company.technology_link') }} ↗</a>
                <a href="{{ App\Support\LocalizedUrl::path('/custom-software-development-afghanistan') }}">{{ __('website.company.software_link') }} ↗</a>
            </div>
        </div>
        <div class="company-proof-facts">
            @foreach(__('website.company.facts') as $fact)
                <article><span>0{{ $loop->iteration }}</span><div><small>{{ $fact['label'] }}</small><strong>{{ $fact['value'] }}</strong></div></article>
            @endforeach
        </div>
    </div>
</section>

<span class="legacy-anchor" id="services" aria-hidden="true"></span>
<section class="section home-section solutions-section" id="solutions">
    <div class="container">
        <div class="section-heading section-heading-grid reveal">
            <div><div class="micro-label"><span>01</span>{{ __('website.sections.solutions_eyebrow') }}</div><h2>{{ __('website.sections.solutions_title') }}</h2></div>
            <div class="heading-aside"><span>MODULAR / SCALABLE / SECURE</span><p>{{ __('website.sections.solutions_description') }}</p></div>
        </div>

        <div class="solution-universe enterprise-capability-grid">
            @foreach($solutions as $solution)
                <a class="solution-card reveal" data-tilt href="{{ App\Support\LocalizedUrl::path($solution['url']) }}">
                    <div class="card-grid" aria-hidden="true"></div>
                    <div class="solution-top"><span class="solution-index">0{{ $loop->iteration }}</span><span class="solution-link">↗</span></div>
                    <div class="solution-object object-{{ $solution['icon'] }}" aria-hidden="true">
                        @if($solution['icon'] === 'layers')
                            <i></i><i></i><i></i><b>ERP</b>
                        @elseif($solution['icon'] === 'chart')
                            <span></span><span></span><span></span><span></span><b>DATA</b>
                        @elseif($solution['icon'] === 'code')
                            <i>&lt;/&gt;</i><span></span><span></span>
                        @else
                            <i><span></span><b>APP</b></i><em></em>
                        @endif
                    </div>
                    <div class="solution-copy"><h3>{{ __("website.solutions.{$solution['key']}.title") }}</h3><p>{{ __("website.solutions.{$solution['key']}.description") }}</p><span class="text-link">{{ __('website.solutions.learn_more') }}<b>↗</b></span></div>
                </a>
            @endforeach
        </div>
    </div>
</section>

@php
    $institutional = match (app()->getLocale()) {
        'fa' => [
            'eyebrow' => 'دولت · NGO · INGO · سازمان‌ها',
            'title' => 'از نرم‌افزار تا دیتاسنتر؛ یک شریک پاسخگو برای پروژه‌های سازمانی.',
            'description' => 'فیدا می‌تواند software، hardware، network، server، cybersecurity، integration، installation، configuration، training و support را در یک پاسخ تخنیکی و تجارتی واضح تنظیم کند.',
            'items' => [
                ['title' => 'RFQ / RFP / Tender', 'text' => 'پاسخ تخنیکی و تجارتی مطابق scope، BOQ، deadline و شرایط تدارکات.'],
                ['title' => 'Supply + Implementation', 'text' => 'تفکیک تجهیزات، لایسنس، نصب، تنظیم، testing، commissioning و training.'],
                ['title' => 'Documentation + Handover', 'text' => 'اسناد معماری، configuration، acceptance، آموزش و حدود support برای تحویل قابل حسابرسی.'],
            ],
            'cta' => 'ارسال RFQ رسمی',
            'secondary' => 'راهکارهای دولت و NGO',
        ],
        'ps' => [
            'eyebrow' => 'دولت · NGO · INGO · سازمانونه',
            'title' => 'له سافټویر څخه تر ډیټا سنټر پورې؛ د سازماني پروژو لپاره یو مسؤل شریک.',
            'description' => 'فیدا software، hardware، network، server، cybersecurity، integration، installation، configuration، training او support په یوه روښانه تخنیکي او سوداګریز ځواب کې تنظیمولای شي.',
            'items' => [
                ['title' => 'RFQ / RFP / Tender', 'text' => 'د scope، BOQ، deadline او تدارکاتي شرایطو مطابق تخنیکي او سوداګریز ځواب.'],
                ['title' => 'Supply + Implementation', 'text' => 'تجهیزات، لایسنس، نصب، تنظیم، testing، commissioning او training جلا او واضح.'],
                ['title' => 'Documentation + Handover', 'text' => 'معماري، configuration، acceptance، روزنه او support حدود د حساب وړ سپارنې لپاره.'],
            ],
            'cta' => 'رسمي RFQ وسپارئ',
            'secondary' => 'د دولت او NGO حللارې',
        ],
        default => [
            'eyebrow' => 'GOVERNMENT · NGO · INGO · ENTERPRISE',
            'title' => 'From software to data centers, one accountable technology partner.',
            'description' => 'Fida can combine software, hardware, networks, servers, cybersecurity, integration, installation, configuration, training and support into one clear technical and commercial response.',
            'items' => [
                ['title' => 'RFQ / RFP / Tender', 'text' => 'Technical and commercial responses aligned to scope, BOQ, deadline and procurement requirements.'],
                ['title' => 'Supply + Implementation', 'text' => 'Equipment, licenses, installation, configuration, testing, commissioning and training separated clearly.'],
                ['title' => 'Documentation + Handover', 'text' => 'Architecture, configuration, acceptance, training and support boundaries for an auditable handover.'],
            ],
            'cta' => 'Submit formal RFQ',
            'secondary' => 'Government & NGO delivery',
        ],
    };
@endphp
<section class="section institutional-section">
    <div class="container institutional-shell reveal">
        <div class="institutional-copy">
            <div class="micro-label"><span>GOV</span>{{ $institutional['eyebrow'] }}</div>
            <h2>{{ $institutional['title'] }}</h2>
            <p>{{ $institutional['description'] }}</p>
            <div class="institutional-actions">
                <a class="button button-lime button-large" href="{{ App\Support\LocalizedUrl::path('/request-for-quotation') }}" data-track-event="cta_click" data-track-label="government_rfq">{{ $institutional['cta'] }}<span class="button-arrow">↗</span></a>
                <a class="button button-wire button-large" href="{{ App\Support\LocalizedUrl::path('/government-ngo-technology-solutions-afghanistan') }}" data-track-event="cta_click" data-track-label="government_ngo_solution">{{ $institutional['secondary'] }}<span class="button-arrow">↗</span></a>
            </div>
        </div>
        <div class="institutional-cards">
            @foreach($institutional['items'] as $item)
                <article><span>0{{ $loop->iteration }}</span><h3>{{ $item['title'] }}</h3><p>{{ $item['text'] }}</p></article>
            @endforeach
        </div>
    </div>
</section>

<span class="legacy-anchor" id="projects" aria-hidden="true"></span>
<section class="section home-section products-section" id="products">
    <div class="product-orbit-bg" aria-hidden="true"></div>
    <div class="container">
        <div class="section-heading section-heading-grid reveal">
            <div><div class="micro-label"><span>02</span>{{ __('website.sections.products_eyebrow') }}</div><h2>{{ __('website.sections.products_title') }}</h2></div>
            <div class="heading-aside"><span>FIDA PRODUCT UNIVERSE</span><p>{{ __('website.sections.products_description') }}</p></div>
        </div>

        <div class="product-bento">
            @foreach($products as $product)
                <article class="product-card product-{{ $product['key'] }} reveal" data-tilt style="--product-accent: {{ $product['accent'] }}">
                    <div class="product-meta"><span class="product-status"><i></i>{{ $product['status'] }}</span><span>FIDA / 0{{ $loop->iteration }}</span></div>
                    <div class="product-copy"><h3>{{ __("website.products.{$product['key']}.name") }}</h3><p>{{ __("website.products.{$product['key']}.description") }}</p><a href="{{ App\Support\LocalizedUrl::path($product['url']) }}" data-track-event="product_view" data-track-label="{{ $product['key'] }}">{{ __('website.products.view') }} <b>↗</b></a></div>
                    <div class="product-interface" aria-hidden="true">
                        <div class="ui-window">
                            <div class="ui-bar"><i></i><i></i><i></i><span>{{ strtoupper($product['key']) }}.OS</span></div>
                            <div class="ui-body">
                                <div class="ui-rail"><span></span><span></span><span></span><span></span></div>
                                <div class="ui-canvas">
                                    <div class="ui-cards"><i></i><i></i><i></i></div>
                                    <div class="ui-chart"><span></span><span></span><span></span><span></span><span></span><span></span></div>
                                    <div class="ui-lines"><i></i><i></i><i></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section home-section industry-section" id="industries">
    <div class="container">
        <div class="industry-intro reveal">
            <div class="micro-label"><span>03</span>{{ __('website.sections.industries_eyebrow') }}</div>
            <h2>{{ __('website.sections.industries_title') }}</h2>
            <div class="industry-counter"><span>06</span><small>SECTORS<br>CONNECTED</small></div>
        </div>
        <div class="industry-rail reveal">
            @foreach($industries as $industry)
                <div class="industry-item"><span>0{{ $loop->iteration }}</span><strong>{{ __("website.industries.{$industry}") }}</strong><i>↗</i></div>
            @endforeach
        </div>
    </div>
</section>

<section class="section home-section process-section" id="process">
    <div class="container process-layout">
        <div class="process-intro reveal">
            <div class="micro-label"><span>04</span>{{ __('website.sections.process_eyebrow') }}</div>
            <h2>{{ __('website.sections.process_title') }}</h2>
            <div class="process-sphere" aria-hidden="true"><i></i><i></i><i></i><span>F</span></div>
        </div>
        <div class="process-timeline">
            @foreach(__('website.process') as $step)
                <article class="process-step reveal"><span>{{ $step['number'] }}</span><div><h3>{{ $step['title'] }}</h3><p>{{ $step['description'] }}</p></div><i></i></article>
            @endforeach
        </div>
    </div>
</section>

@include('marketing.partials.contact-section', ['sectionClass' => 'home-section'])
@endsection
