@extends('layouts.marketing')

@section('content')
@php
    $orgTypes = __('website.rfq.organization_types');
    $procurementTypes = __('website.rfq.procurement_types');
@endphp

<section class="page-hero detail-page-hero rfq-page-hero">
    <div class="page-hero-glow"></div>
    <div class="container narrow reveal">
        <nav class="page-breadcrumbs" aria-label="{{ __('website.page.breadcrumbs') }}">
            <a href="{{ App\Support\LocalizedUrl::path('/') }}">{{ __('website.page.home') }}</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">{{ $page->translation('title') }}</span>
        </nav>
        <div class="micro-label"><span>RFQ</span>{{ $page->translation('eyebrow') }}</div>
        <h1>{{ $page->translation('title') }}</h1>
        <p>{{ $page->translation('summary') }}</p>
        <div class="rfq-hero-trust">
            <span>RFQ / RFP / TOR / BoQ</span>
            <span>PRIVATE DOCUMENT STORAGE</span>
            <span>EMAIL TO INFO@FIDA.AF</span>
        </div>
    </div>
</section>

<section class="rfq-intake-section" id="rfq">
    <div class="container rfq-intake-grid">
        <div class="rfq-intake-copy reveal">
            <div class="micro-label"><span>01</span>{{ __('website.rfq.eyebrow') }}</div>
            <h2>{{ __('website.rfq.title') }}</h2>
            <p>{{ __('website.rfq.description') }}</p>

            <div class="rfq-readiness">
                <article><strong>01</strong><div><span>{{ __('website.rfq.scope_title') }}</span><p>{{ __('website.rfq.scope_text') }}</p></div></article>
                <article><strong>02</strong><div><span>{{ __('website.rfq.documents_title') }}</span><p>{{ __('website.rfq.documents_text') }}</p></div></article>
                <article><strong>03</strong><div><span>{{ __('website.rfq.response_title') }}</span><p>{{ __('website.rfq.response_text') }}</p></div></article>
            </div>

            <div class="rfq-contact-note">
                <small>PROCUREMENT EMAIL</small>
                <a href="mailto:info@fida.af">info@fida.af</a>
            </div>
        </div>

        <form class="rfq-form reveal" action="{{ route('rfqs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
            <input type="hidden" name="source_url" value="{{ url()->current() }}">
            <div class="honeypot" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

            <div class="form-console"><span class="live-dot"></span><b>{{ __('website.rfq.form_title') }}</b><small>{{ __('website.rfq.form_secure') }}</small></div>

            @if(session('rfq_success'))
                <div class="rfq-success" role="status" data-conversion="rfq_submit">
                    <strong>{{ __('website.rfq.success_title') }}</strong>
                    <p>{{ __('website.rfq.success_text', ['reference' => session('rfq_success')]) }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="form-errors" role="alert"><strong>{{ __('website.contact.review') }}</strong></div>
            @endif

            <fieldset>
                <legend>{{ __('website.rfq.organization_section') }}</legend>
                <div class="form-grid">
                    <label><span>{{ __('website.rfq.organization') }}</span><input name="organization" value="{{ old('organization') }}" required autocomplete="organization" @class(['invalid' => $errors->has('organization')])></label>
                    <label><span>{{ __('website.rfq.organization_type') }}</span><select name="organization_type" required @class(['invalid' => $errors->has('organization_type')])><option value="">—</option>@foreach($orgTypes as $value => $label)<option value="{{ $value }}" @selected(old('organization_type') === $value)>{{ $label }}</option>@endforeach</select></label>
                    <label><span>{{ __('website.rfq.contact_name') }}</span><input name="contact_name" value="{{ old('contact_name') }}" required autocomplete="name" @class(['invalid' => $errors->has('contact_name')])></label>
                    <label><span>{{ __('website.rfq.job_title') }}</span><input name="job_title" value="{{ old('job_title') }}" autocomplete="organization-title"></label>
                    <label><span>{{ __('website.rfq.email') }}</span><input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" @class(['invalid' => $errors->has('email')])></label>
                    <label><span>{{ __('website.rfq.phone') }}</span><input name="phone" value="{{ old('phone') }}" autocomplete="tel" dir="ltr"></label>
                </div>
            </fieldset>

            <fieldset>
                <legend>{{ __('website.rfq.requirement_section') }}</legend>
                <div class="form-grid">
                    <label class="form-wide"><span>{{ __('website.rfq.project_title') }}</span><input name="project_title" value="{{ old('project_title') }}" required @class(['invalid' => $errors->has('project_title')])></label>
                    <label><span>{{ __('website.rfq.procurement_type') }}</span><select name="procurement_type" required @class(['invalid' => $errors->has('procurement_type')])><option value="">—</option>@foreach($procurementTypes as $value => $label)<option value="{{ $value }}" @selected(old('procurement_type') === $value)>{{ $label }}</option>@endforeach</select></label>
                    <label><span>{{ __('website.rfq.deadline') }}</span><input type="date" name="submission_deadline" value="{{ old('submission_deadline') }}"></label>
                    <label><span>{{ __('website.rfq.location') }}</span><input name="location" value="{{ old('location') }}"></label>
                    <label><span>{{ __('website.rfq.budget') }}</span><input name="budget" value="{{ old('budget') }}" placeholder="{{ __('website.rfq.budget_placeholder') }}"></label>
                    <label class="form-wide"><span>{{ __('website.rfq.requirements') }}</span><textarea name="requirements" rows="8" required @class(['invalid' => $errors->has('requirements')])>{{ old('requirements') }}</textarea><small>{{ __('website.rfq.requirements_help') }}</small></label>
                    <label class="form-wide rfq-file-field"><span>{{ __('website.rfq.documents') }}</span><input type="file" name="documents[]" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"><small>{{ __('website.rfq.documents_help') }}</small></label>
                </div>
            </fieldset>

            <div class="rfq-form-footer">
                <p>{{ __('website.rfq.privacy') }}</p>
                <button class="button button-lime form-submit" type="submit">{{ __('website.rfq.submit') }}<span class="button-arrow">↗</span></button>
            </div>
        </form>
    </div>
</section>

<section class="page-content-section rfq-content-section">
    <div class="container content-layout">
        <article class="prose reveal">{!! $page->translation('body') !!}</article>
        <aside class="page-cta reveal">
            <span>FIDA PROCUREMENT DESK</span>
            <h2>{{ __('website.rfq.direct_title') }}</h2>
            <p>{{ __('website.rfq.direct_text') }}</p>
            <a class="button button-wire" href="mailto:info@fida.af">info@fida.af <span class="button-arrow">↗</span></a>
        </aside>
    </div>
</section>

@if($faqs !== [])
<section class="page-faq-section" id="frequently-asked-questions">
    <div class="container page-section-grid">
        <div class="page-section-intro reveal">
            <div class="micro-label"><span>02</span>{{ __('website.page.faq_eyebrow') }}</div>
            <h2>{{ __('website.page.faq_title') }}</h2>
            <p>{{ __('website.page.faq_description') }}</p>
        </div>
        <div class="faq-list reveal">
            @foreach($faqs as $faq)
                <details class="faq-item" lang="{{ $faq['locale'] }}" dir="{{ config("website.locales.{$faq['locale']}.direction", 'ltr') }}" @if($loop->first) open @endif>
                    <summary><span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>{{ $faq['question'] }}<i aria-hidden="true">+</i></summary>
                    <p>{{ $faq['answer'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
