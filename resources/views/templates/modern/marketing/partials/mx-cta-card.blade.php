{{-- Sticky call-to-action card beside page content. Accepts $heading, $description, $primaryUrl, $primaryLabel, $secondaryUrl, $secondaryLabel, $trackLabel. --}}
<aside class="mx-cta-card">
    <div class="mx-cta-brand">@include('marketing.templates.modern.partials.logo', ['uid' => 'cta-'.($trackLabel ?? 'page'), 'height' => 24, 'light' => true])<span>{{ config('website.name') }}</span></div>
    <h2>{{ $heading }}</h2>
    <p>{{ $description }}</p>
    <div class="mx-cta-actions">
        <a class="mx-button mx-button-primary" href="{{ $primaryUrl }}" data-track-event="cta_click" data-track-label="{{ $trackLabel ?? 'page' }}">{{ $primaryLabel }}</a>
        @if($secondaryUrl ?? null)
            <a class="mx-button mx-button-ghost" href="{{ $secondaryUrl }}">{{ $secondaryLabel }}</a>
        @endif
    </div>
    <ul class="mx-cta-contact">
        <li><a href="https://wa.me/{{ config('website.whatsapp') }}" rel="noopener" dir="ltr" data-track-event="contact_click" data-track-label="whatsapp">WhatsApp {{ config('website.phone') }}</a></li>
        <li><a href="mailto:{{ config('website.email') }}" data-track-event="contact_click" data-track-label="email">{{ config('website.email') }}</a></li>
    </ul>
</aside>
