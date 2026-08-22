<section class="section contact-section" id="contact">
    <div class="container contact-shell reveal">
        <div class="contact-grid-bg" aria-hidden="true"></div>
        <div class="contact-copy">
            <div class="micro-label"><span>05</span>{{ __('website.sections.contact_eyebrow') }}</div>
            <h2>{{ __('website.sections.contact_title') }}</h2>
            <p>{{ __('website.sections.contact_description') }}</p>
            @if(isset($page) && $page instanceof \App\Models\ContentPage && $page->slug === 'contact')
                <div class="contact-page-note prose">{!! $page->translation('body') !!}</div>
            @endif
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
            @if($errors->any())<div class="form-errors" role="alert"><strong>{{ __('website.contact.review') }}</strong></div>@endif

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
