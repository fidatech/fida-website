@php
    $projectOptions = __('website.contact.project_options');
    $requestedProjectType = (string) request('request');
    $requestedProjectType = is_array($projectOptions) && array_key_exists($requestedProjectType, $projectOptions) ? $requestedProjectType : '';
    $selectedProjectType = old('project_type', $requestedProjectType);
    $interest = request('interest', isset($page) && $page instanceof \App\Models\ContentPage && ! in_array($page->slug, ['contact', 'pricing'], true) ? $page->slug : '');
@endphp
<section class="mx-section mx-contact" id="contact">
    <div class="mx-wrap mx-contact-grid">
        <div class="mx-contact-copy">
            <h2>{{ __('modern.contact.title') }}</h2>
            <p>{{ __('modern.contact.lead') }}</p>
            @if(isset($page) && $page instanceof \App\Models\ContentPage && $page->slug === 'contact')
                <div class="mx-prose">{!! $page->translation('body') !!}</div>
            @endif
            <dl class="mx-contact-direct">
                <div><dt>{{ __('modern.contact.email') }}</dt><dd><a href="mailto:{{ config('website.email') }}" data-track-event="contact_click" data-track-label="email">{{ config('website.email') }}</a></dd></div>
                <div><dt>{{ __('modern.contact.whatsapp') }}</dt><dd><a href="https://wa.me/{{ config('website.whatsapp') }}" rel="noopener" dir="ltr" data-track-event="contact_click" data-track-label="whatsapp">{{ config('website.phone') }}</a></dd></div>
                <div><dt>{{ __('modern.contact.office') }}</dt><dd>{{ config('website.address.line') }}, {{ config('website.address.city') }}</dd></div>
            </dl>
        </div>

        <form class="mx-form" action="{{ route('leads.store') }}" method="post">
            @csrf
            <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
            <input type="hidden" name="source_url" value="{{ url()->current() }}">
            <input type="hidden" name="interest_slug" value="{{ $interest }}">
            <input type="hidden" name="utm_source" value="{{ request('utm_source') }}">
            <input type="hidden" name="utm_medium" value="{{ request('utm_medium') }}">
            <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">
            <div class="honeypot" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

            @if(session('lead_success'))<div class="mx-form-success" role="status" data-conversion="generate_lead">{{ session('lead_success') }}</div>@endif
            @if($errors->any())<div class="mx-form-errors" role="alert">{{ __('website.contact.review') }}</div>@endif

            <div class="mx-form-grid">
                <label><span>{{ __('website.contact.name') }}</span><input name="name" value="{{ old('name') }}" required autocomplete="name" @if($errors->has('name')) aria-invalid="true" @endif></label>
                <label><span>{{ __('website.contact.company') }}</span><input name="company" value="{{ old('company') }}" autocomplete="organization"></label>
                <label><span>{{ __('website.contact.email') }}</span><input type="email" name="email" value="{{ old('email') }}" autocomplete="email" dir="ltr" @if($errors->has('email')) aria-invalid="true" @endif></label>
                <label><span>{{ __('website.contact.phone') }}</span><input name="phone" value="{{ old('phone') }}" autocomplete="tel" dir="ltr" @if($errors->has('phone')) aria-invalid="true" @endif></label>
                <label><span>{{ __('website.contact.project_type') }}</span>
                    <select name="project_type" required @if($errors->has('project_type')) aria-invalid="true" @endif>
                        <option value="">—</option>
                        @foreach($projectOptions as $value => $label)<option value="{{ $value }}" @selected($selectedProjectType === $value)>{{ $label }}</option>@endforeach
                    </select>
                </label>
                <label><span>{{ __('website.contact.budget') }}</span>
                    <select name="budget">
                        <option value="">—</option>
                        @foreach(__('website.contact.budget_options') as $value => $label)<option value="{{ $value }}" @selected(old('budget') === $value)>{{ $label }}</option>@endforeach
                    </select>
                </label>
                <label class="mx-form-wide"><span>{{ __('website.contact.message') }}</span><textarea name="message" rows="5" required @if($errors->has('message')) aria-invalid="true" @endif>{{ old('message') }}</textarea></label>
            </div>
            <button class="mx-button mx-button-saffron" type="submit">{{ __('modern.contact.send') }}</button>
        </form>
    </div>
</section>
