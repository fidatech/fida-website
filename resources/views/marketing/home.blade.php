@extends('layouts.marketing')

@section('content')
<section class="hero">
    <div class="hero-glow hero-glow-one"></div>
    <div class="hero-glow hero-glow-two"></div>
    <div class="container hero-grid">
        <div class="hero-copy reveal">
            <div class="eyebrow"><span></span>{{ __('website.hero.eyebrow') }}</div>
            <h1>{{ __('website.hero.title_before') }} <em>{{ __('website.hero.title_emphasis') }}</em></h1>
            <p class="hero-description">{{ __('website.hero.description') }}</p>
            <div class="hero-actions">
                <a class="button button-primary" href="#contact">{{ __('website.hero.primary_cta') }} <span aria-hidden="true">↗</span></a>
                <a class="button button-ghost" href="#solutions">{{ __('website.hero.secondary_cta') }}</a>
            </div>
            <div class="hero-trust">
                <div class="trust-avatars" aria-hidden="true"><span>FT</span><span>ERP</span><span>AF</span></div>
                <p>{{ __('website.hero.trust') }}</p>
            </div>
        </div>

        <div class="hero-visual reveal" aria-label="Business software dashboard preview">
            <div class="visual-orbit orbit-one"></div>
            <div class="visual-orbit orbit-two"></div>
            <div class="dashboard-shell">
                <div class="dashboard-topbar">
                    <div class="window-dots"><i></i><i></i><i></i></div>
                    <span>{{ __('website.hero.dashboard_label') }}</span>
                    <div class="dashboard-avatar">FT</div>
                </div>
                <div class="dashboard-body">
                    <aside class="dashboard-sidebar" aria-hidden="true">
                        <span class="active"></span><span></span><span></span><span></span><span></span>
                    </aside>
                    <div class="dashboard-content">
                        <div class="metric-row">
                            <article><span>{{ __('website.hero.revenue') }}</span><strong>$284K</strong><small>+18.4%</small></article>
                            <article><span>{{ __('website.hero.operations') }}</span><strong>1,248</strong><small>{{ __('website.hero.active') }}</small></article>
                        </div>
                        <div class="chart-card">
                            <div class="chart-heading"><span>{{ __('website.hero.growth') }}</span><strong>+24.8%</strong></div>
                            <svg viewBox="0 0 430 170" preserveAspectRatio="none" role="img" aria-label="Growth trend">
                                <defs><linearGradient id="chartFill" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#6f6bff" stop-opacity=".48"/><stop offset="1" stop-color="#6f6bff" stop-opacity="0"/></linearGradient></defs>
                                <path class="chart-area" d="M0 148 C48 132 58 112 101 122 S170 95 211 104 S285 45 326 66 S378 26 430 16 L430 170 L0 170 Z"/>
                                <path class="chart-line" d="M0 148 C48 132 58 112 101 122 S170 95 211 104 S285 45 326 66 S378 26 430 16"/>
                            </svg>
                        </div>
                        <div class="activity-row"><span></span><span></span><span></span></div>
                    </div>
                </div>
            </div>
            <div class="floating-card secure-card"><i>✓</i><span>{{ __('website.hero.secure') }}</span></div>
            <div class="floating-card growth-card"><strong>+32%</strong><span>{{ __('website.hero.growth') }}</span></div>
        </div>
    </div>

    <div class="container stat-strip">
        @foreach(config('website.stats') as $stat)
            <div><strong>{{ $stat['value'] }}</strong><span>{{ $stat['label'] }}</span></div>
        @endforeach
        <div class="stat-technologies"><span>Laravel</span><span>Flutter</span><span>MySQL</span><span>Cloud</span></div>
    </div>
</section>

<section class="section solutions-section" id="solutions">
    <div class="container">
        <div class="section-heading split-heading reveal">
            <div><div class="eyebrow"><span></span>{{ __('website.sections.solutions_eyebrow') }}</div><h2>{{ __('website.sections.solutions_title') }}</h2></div>
            <p>{{ __('website.sections.solutions_description') }}</p>
        </div>
        <div class="solution-grid">
            @foreach($solutions as $solution)
                <a class="solution-card reveal" href="{{ App\Support\LocalizedUrl::path($solution['url']) }}">
                    <div class="solution-icon icon-{{ $solution['icon'] }}" aria-hidden="true">
                        @if($solution['icon'] === 'layers')<svg viewBox="0 0 24 24"><path d="m12 3 9 5-9 5-9-5 9-5Z"/><path d="m3 12 9 5 9-5M3 16l9 5 9-5"/></svg>
                        @elseif($solution['icon'] === 'chart')<svg viewBox="0 0 24 24"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/></svg>
                        @elseif($solution['icon'] === 'code')<svg viewBox="0 0 24 24"><path d="m8 9-4 3 4 3M16 9l4 3-4 3M14 5l-4 14"/></svg>
                        @else<svg viewBox="0 0 24 24"><rect x="6" y="2" width="12" height="20" rx="3"/><path d="M10 18h4"/></svg>@endif
                    </div>
                    <span class="card-number">0{{ $loop->iteration }}</span>
                    <h3>{{ __("website.solutions.{$solution['key']}.title") }}</h3>
                    <p>{{ __("website.solutions.{$solution['key']}.description") }}</p>
                    <span class="text-link">{{ __('website.solutions.learn_more') }} <b>↗</b></span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section products-section" id="products">
    <div class="container">
        <div class="section-heading centered reveal">
            <div class="eyebrow"><span></span>{{ __('website.sections.products_eyebrow') }}</div>
            <h2>{{ __('website.sections.products_title') }}</h2>
            <p>{{ __('website.sections.products_description') }}</p>
        </div>
        <div class="product-grid">
            @foreach($products as $product)
                <article class="product-card reveal" style="--product-accent: {{ $product['accent'] }}">
                    <div class="product-top"><span class="product-badge">{{ $product['status'] }}</span><span class="product-arrow">↗</span></div>
                    <div class="product-mark">{{ strtoupper(substr($product['key'], 0, 1)) }}</div>
                    <h3>{{ __("website.products.{$product['key']}.name") }}</h3>
                    <p>{{ __("website.products.{$product['key']}.description") }}</p>
                    <a href="#contact">{{ __('website.products.view') }}</a>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section industry-section" id="industries">
    <div class="container industry-layout">
        <div class="industry-copy reveal">
            <div class="eyebrow"><span></span>{{ __('website.sections.industries_eyebrow') }}</div>
            <h2>{{ __('website.sections.industries_title') }}</h2>
        </div>
        <div class="industry-list reveal">
            @foreach($industries as $industry)
                <div><span>0{{ $loop->iteration }}</span><strong>{{ __("website.industries.{$industry}") }}</strong><i>↗</i></div>
            @endforeach
        </div>
    </div>
</section>

<section class="section process-section" id="process">
    <div class="container">
        <div class="section-heading centered reveal">
            <div class="eyebrow"><span></span>{{ __('website.sections.process_eyebrow') }}</div>
            <h2>{{ __('website.sections.process_title') }}</h2>
        </div>
        <div class="process-grid">
            @foreach(__('website.process') as $step)
                <article class="process-card reveal"><span>{{ $step['number'] }}</span><h3>{{ $step['title'] }}</h3><p>{{ $step['description'] }}</p></article>
            @endforeach
        </div>
    </div>
</section>

<section class="section contact-section" id="contact">
    <div class="container contact-layout">
        <div class="contact-copy reveal">
            <div class="eyebrow"><span></span>{{ __('website.sections.contact_eyebrow') }}</div>
            <h2>{{ __('website.sections.contact_title') }}</h2>
            <p>{{ __('website.sections.contact_description') }}</p>
            <div class="contact-direct">
                <a href="mailto:{{ config('website.email') }}">{{ config('website.email') }}</a>
                <a href="https://wa.me/{{ config('website.whatsapp') }}" rel="noopener" dir="ltr">WhatsApp · {{ config('website.phone') }}</a>
            </div>
        </div>
        <form class="lead-form reveal" action="{{ route('leads.store') }}" method="post">
            @csrf
            <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
            <input type="hidden" name="source_url" value="{{ url()->current() }}">
            <input type="hidden" name="utm_source" value="{{ request('utm_source') }}">
            <input type="hidden" name="utm_medium" value="{{ request('utm_medium') }}">
            <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">
            <div class="honeypot" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

            @if(session('lead_success'))<div class="form-success" role="status">{{ session('lead_success') }}</div>@endif
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
            <button class="button button-primary form-submit" type="submit">{{ __('website.contact.send') }} <span>↗</span></button>
        </form>
    </div>
</section>
@endsection
