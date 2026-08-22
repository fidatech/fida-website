@extends('layouts.marketing')

@section('content')
<section class="hero" data-hero>
    <div class="hero-grid-lines" aria-hidden="true"></div>
    <div class="hero-index" aria-hidden="true">F / 27</div>
    <div class="container hero-layout">
        <div class="hero-copy reveal">
            <div class="system-pill"><span class="system-pulse"></span>{{ __('website.hero.eyebrow') }}<b>2027 READY</b></div>
            <h1>{{ __('website.hero.title_before') }} <em>{{ __('website.hero.title_emphasis') }}</em></h1>
            <p class="hero-description">{{ __('website.hero.description') }}</p>
            <div class="hero-actions">
                <a class="button button-lime button-large" href="#contact" data-track-event="cta_click" data-track-label="hero_primary">{{ __('website.hero.primary_cta') }}<span class="button-arrow">↗</span></a>
                <a class="button button-wire button-large" href="#solutions"><span class="play-mark">▶</span>{{ __('website.hero.secondary_cta') }}</a>
            </div>
            <div class="hero-proof">
                <div class="proof-stack" aria-hidden="true"><span>ERP</span><span>AF</span><span>AI</span></div>
                <p>{{ __('website.hero.trust') }}</p>
                <svg viewBox="0 0 42 12" aria-hidden="true"><path d="M1 10 8 5l7 3 8-7 8 4 10-4"/></svg>
            </div>
        </div>

        <div class="core-stage reveal" data-core-stage aria-label="Fida business technology core">
            <div class="stage-readout stage-readout-top"><span>FIDA CORE</span><b>ONLINE</b></div>
            <div class="core-scene" data-core-scene>
                <div class="scene-shadow"></div>
                <div class="scene-ring scene-ring-outer"></div>
                <div class="scene-ring scene-ring-inner"></div>
                <div class="orbit orbit-one"><span class="orbit-node node-erp">ERP</span><span class="orbit-node node-ai">AI</span></div>
                <div class="orbit orbit-two"><span class="orbit-node node-data">DATA</span><span class="orbit-node node-cloud">CLOUD</span></div>

                <div class="core-cube" aria-hidden="true">
                    <div class="cube-face cube-front"><span>F</span><small>BUSINESS OS</small></div>
                    <div class="cube-face cube-back"><span>27</span></div>
                    <div class="cube-face cube-right"><i></i><i></i><i></i></div>
                    <div class="cube-face cube-left"><b>01</b><b>10</b><b>11</b></div>
                    <div class="cube-face cube-top"></div>
                    <div class="cube-face cube-bottom"></div>
                </div>

                <div class="float-panel panel-signal">
                    <div class="panel-label"><span></span>LIVE SIGNAL</div>
                    <div class="signal-value">99.9<small>%</small></div>
                    <svg viewBox="0 0 124 34" preserveAspectRatio="none" aria-hidden="true"><path d="M1 27 14 21l12 4 13-16 13 10 13-6 13 9 13-17 13 7 19-9"/></svg>
                </div>
                <div class="float-panel panel-modules">
                    <div class="panel-label">CONNECTED MODULES</div>
                    <div class="module-row"><i></i><i></i><i></i><i></i><i></i></div>
                    <strong>18 <small>ACTIVE</small></strong>
                </div>
                <div class="float-panel panel-command"><span>⌁</span><div><small>SMART COMMAND</small><strong>Ask your business.</strong></div></div>
            </div>
            <div class="stage-readout stage-readout-bottom"><span>KBL · 34.55°N</span><span>LATENCY 24MS</span></div>
        </div>
    </div>

    <div class="container metric-deck reveal">
        @foreach(config('website.stats') as $stat)
            <article><span>0{{ $loop->iteration }}</span><strong>{{ $stat['value'] }}</strong><p>{{ __("website.stats.{$stat['key']}") }}</p></article>
        @endforeach
        <article class="metric-stack"><span>04</span><div><b>LARAVEL</b><b>FLUTTER</b><b>MYSQL</b><b>CLOUD</b></div><p>ENGINEERED STACK</p></article>
    </div>
</section>

<section class="ticker" aria-label="Fida capabilities">
    <div class="ticker-track">
        @for($i = 0; $i < 2; $i++)
            <span>ERP SYSTEMS <b>✦</b> FINTECH <b>✦</b> MOBILE APPS <b>✦</b> AI WORKFLOWS <b>✦</b> CLOUD PLATFORMS <b>✦</b> DATA INTELLIGENCE <b>✦</b></span>
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
                <a href="{{ App\Support\LocalizedUrl::path('/technology-company-afghanistan') }}">{{ __('website.company.technology_link') }} ↗</a>
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

<section class="section solutions-section" id="solutions">
    <div class="container">
        <div class="section-heading section-heading-grid reveal">
            <div><div class="micro-label"><span>01</span>{{ __('website.sections.solutions_eyebrow') }}</div><h2>{{ __('website.sections.solutions_title') }}</h2></div>
            <div class="heading-aside"><span>MODULAR / SCALABLE / SECURE</span><p>{{ __('website.sections.solutions_description') }}</p></div>
        </div>

        <div class="solution-universe">
            @foreach($solutions as $solution)
                <a class="solution-card reveal" data-tilt href="{{ App\Support\LocalizedUrl::path($solution['url']) }}">
                    <div class="card-grid" aria-hidden="true"></div>
                    <div class="solution-top"><span class="solution-index">0{{ $loop->iteration }}</span><span class="solution-link">↗</span></div>
                    <div class="solution-object object-{{ $solution['icon'] }}" aria-hidden="true">
                        @if($solution['icon'] === 'layers')
                            <i></i><i></i><i></i><b>ERP</b>
                        @elseif($solution['icon'] === 'chart')
                            <span></span><span></span><span></span><span></span><b>+24%</b>
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

<section class="section products-section" id="products">
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

<section class="section industry-section" id="industries">
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

<section class="section process-section" id="process">
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

<section class="section contact-section" id="contact">
    <div class="container contact-shell reveal">
        <div class="contact-grid-bg" aria-hidden="true"></div>
        <div class="contact-copy">
            <div class="micro-label"><span>05</span>{{ __('website.sections.contact_eyebrow') }}</div>
            <h2>{{ __('website.sections.contact_title') }}</h2>
            <p>{{ __('website.sections.contact_description') }}</p>
            <div class="contact-direct">
                <a href="mailto:{{ config('website.email') }}" data-track-event="contact_click" data-track-label="email"><span>EMAIL</span>{{ config('website.email') }}</a>
                <a href="https://wa.me/{{ config('website.whatsapp') }}" rel="noopener" dir="ltr" data-track-event="contact_click" data-track-label="whatsapp"><span>WHATSAPP</span>{{ config('website.phone') }}</a>
            </div>
        </div>
        <form class="lead-form" action="{{ route('leads.store') }}" method="post">
            @csrf
            <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
            <input type="hidden" name="source_url" value="{{ url()->current() }}">
            <input type="hidden" name="utm_source" value="{{ request('utm_source') }}">
            <input type="hidden" name="utm_medium" value="{{ request('utm_medium') }}">
            <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">
            <div class="honeypot" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

            <div class="form-console"><span class="live-dot"></span><b>PROJECT INTAKE</b><small>SECURE CHANNEL / 256-BIT</small></div>
            @if(session('lead_success'))<div class="form-success" role="status" data-conversion="generate_lead">{{ session('lead_success') }}</div>@endif
            @if($errors->any())<div class="form-errors" role="alert"><strong>Please review the highlighted fields.</strong></div>@endif

            <div class="form-grid">
                <label><span>{{ __('website.contact.name') }}</span><input name="name" value="{{ old('name') }}" required autocomplete="name" @class(['invalid' => $errors->has('name')])></label>
                <label><span>{{ __('website.contact.company') }}</span><input name="company" value="{{ old('company') }}" autocomplete="organization"></label>
                <label><span>{{ __('website.contact.email') }}</span><input type="email" name="email" value="{{ old('email') }}" autocomplete="email" @class(['invalid' => $errors->has('email')])></label>
                <label><span>{{ __('website.contact.phone') }}</span><input name="phone" value="{{ old('phone') }}" autocomplete="tel" dir="ltr" @class(['invalid' => $errors->has('phone')])></label>
                <label><span>{{ __('website.contact.project_type') }}</span><select name="project_type" required @class(['invalid' => $errors->has('project_type')])><option value="">—</option>@foreach(__('website.contact.project_options') as $value => $label)<option value="{{ $value }}" @selected(old('project_type') === $value)>{{ $label }}</option>@endforeach</select></label>
                <label><span>{{ __('website.contact.budget') }}</span><select name="budget"><option value="">—</option>@foreach(__('website.contact.budget_options') as $value => $label)<option value="{{ $value }}" @selected(old('budget') === $value)>{{ $label }}</option>@endforeach</select></label>
                <label class="form-wide"><span>{{ __('website.contact.message') }}</span><textarea name="message" rows="5" required @class(['invalid' => $errors->has('message')])>{{ old('message') }}</textarea></label>
            </div>
            <button class="button button-lime form-submit" type="submit">{{ __('website.contact.send') }}<span class="button-arrow">↗</span></button>
        </form>
    </div>
</section>
@endsection
