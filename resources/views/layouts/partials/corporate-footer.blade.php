@php
    $footerText = match ($locale) {
        'fa' => [
            'eyebrow' => 'با فیدا کار کنید',
            'headline' => 'برای پروژه بعدی خود به یک شریک تخنیکی نیاز دارید؟',
            'intro' => 'در مورد سیستم ERP، سافتویر اختصاصی یا خدمات زیربنای IT با تیم ما صحبت کنید.',
            'proposal' => 'درخواست پیشنهاد',
            'contact' => 'تماس با ما',
            'company' => 'شرکت',
            'solutions' => 'خدمات و راهکارها',
            'custom' => 'توسعه سافتویر اختصاصی',
            'products' => 'محصولات',
            'find' => 'دفتر ما',
            'map' => 'مشاهده در نقشه',
            'follow' => 'صفحات رسمی',
            'rights' => 'تمام حقوق محفوظ است.',
        ],
        'ps' => [
            'eyebrow' => 'له فیدا سره کار وکړئ',
            'headline' => 'د راتلونکې پروژې لپاره تخنیکي همکار ته اړتیا لرئ؟',
            'intro' => 'د ERP سیسټم، ځانګړي سافټویر یا د IT زیربنا خدمتونو په اړه زموږ له ټیم سره خبرې وکړئ.',
            'proposal' => 'د وړاندیز غوښتنه',
            'contact' => 'اړیکه ونیسئ',
            'company' => 'شرکت',
            'solutions' => 'خدمتونه او حللارې',
            'custom' => 'د ځانګړي سافټویر جوړول',
            'products' => 'محصولات',
            'find' => 'زموږ دفتر',
            'map' => 'په نقشه کې یې وګورئ',
            'follow' => 'رسمي پاڼې',
            'rights' => 'ټول حقونه خوندي دي.',
        ],
        default => [
            'eyebrow' => 'WORK WITH FIDA',
            'headline' => 'Need a reliable technology partner?',
            'intro' => 'Tell us about your ERP, custom software or IT infrastructure requirements. We will help you define the next step.',
            'proposal' => 'Request a proposal',
            'contact' => 'Contact our team',
            'company' => 'Company',
            'solutions' => 'Services & solutions',
            'custom' => 'Custom software development',
            'products' => 'Business software',
            'find' => 'Visit our office',
            'map' => 'View on Google Maps',
            'follow' => 'Official channels',
            'rights' => 'All rights reserved.',
        ],
    };
    $footerProfiles = array_filter(config('website.official_profiles', []), fn ($url) => is_string($url) && filter_var($url, FILTER_VALIDATE_URL));
    $footerMapUrl = config('website.google_maps_url') ?: 'https://www.google.com/maps/search/?api=1&query=34.5143264%2C69.1840542';
    $footerMapEmbedUrl = config('website.map_embed_url') ?: 'https://www.google.com/maps?q=34.5143264,69.1840542&z=17&output=embed';
@endphp
<footer class="site-footer corp-footer">
    <div class="container">
        <div class="corp-footer-cta">
            <div class="corp-footer-cta-copy">
                <span class="corp-footer-kicker">{{ $footerText['eyebrow'] }}</span>
                <h2>{{ $footerText['headline'] }}</h2>
                <p>{{ $footerText['intro'] }}</p>
            </div>
            <div class="corp-footer-cta-actions">
                <a class="corp-footer-primary" href="{{ \App\Support\LocalizedUrl::path('/request-for-quotation') }}" data-track-event="cta_click" data-track-label="corporate_footer_proposal">{{ $footerText['proposal'] }} <span aria-hidden="true">↗</span></a>
                <a class="corp-footer-secondary" href="{{ \App\Support\LocalizedUrl::path('/contact') }}" data-track-event="cta_click" data-track-label="corporate_footer_contact">{{ $footerText['contact'] }} <span aria-hidden="true">→</span></a>
            </div>
        </div>

        <div class="corp-footer-main">
            <div class="corp-footer-identity">
                <a class="corp-footer-logo" href="{{ \App\Support\LocalizedUrl::path('/') }}" aria-label="{{ config('website.name') }}">
                    @if(config('website.branding.logo_url'))
                        <img src="{{ config('website.branding.logo_url') }}" width="51" height="51" alt="">
                    @else
                        <span class="corp-footer-logo-mark" aria-hidden="true">F</span>
                    @endif
                    <span><strong>{{ config('website.branding.name') }}</strong><small>{{ config('website.branding.tagline') }}</small></span>
                </a>
                <p>{{ __('website.footer.description') }}</p>
                <div class="corp-footer-contact-details">
                    <a href="mailto:{{ config('website.email') }}">{{ config('website.email') }}</a>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', (string) config('website.phone')) }}" dir="ltr">{{ config('website.phone') }}</a>
                </div>
            </div>

            <nav class="corp-footer-nav" aria-label="{{ __('website.accessibility.primary_navigation') }}">
                <div class="corp-footer-column">
                    <h3>{{ $footerText['company'] }}</h3>
                    <a href="{{ \App\Support\LocalizedUrl::path('/about') }}">{{ __('website.nav.about') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/company-facts') }}">{{ __('website.nav.company_facts') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/projects') }}">{{ __('website.nav.projects') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/articles') }}">{{ __('website.nav.articles') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/contact') }}">{{ __('website.nav.contact') }}</a>
                </div>
                <div class="corp-footer-column">
                    <h3>{{ $footerText['solutions'] }}</h3>
                    <a href="{{ \App\Support\LocalizedUrl::path('/erpnext-afghanistan') }}">ERPNext</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/enterprise-software-afghanistan') }}">{{ __('website.solutions.erp.title') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/custom-software-development-afghanistan') }}">{{ $footerText['custom'] }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/web-digital-platforms-afghanistan') }}">{{ __('website.solutions.web.title') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::path('/services') }}">{{ __('website.nav.all_services') }}</a>
                </div>
                <div class="corp-footer-column">
                    <h3>{{ $footerText['products'] }}</h3>
                    @foreach(config('website.products', []) as $product)
                        <a href="{{ \App\Support\LocalizedUrl::path($product['url']) }}">{{ __("website.products.{$product['key']}.name") }}</a>
                    @endforeach
                    <a href="{{ \App\Support\LocalizedUrl::path('/products') }}">{{ __('website.nav.all_products') }} ↗</a>
                </div>
            </nav>
        </div>

        <section class="corp-footer-location" aria-label="{{ $footerText['find'] }}">
            <div class="corp-footer-location-content">
                <span class="corp-footer-location-kicker">{{ $footerText['find'] }}</span>
                <h3>{{ config('website.address.city') }}, {{ config('website.address.country') }}</h3>
                <p>@if(config('website.address.line')){{ config('website.address.line') }}@endif</p>
                <a class="corp-footer-map-button" href="{{ $footerMapUrl }}" target="_blank" rel="noopener noreferrer">{{ $footerText['map'] }} <span aria-hidden="true">↗</span></a>
                @if($footerProfiles !== [])
                    <div class="corp-footer-follow">
                        <strong>{{ $footerText['follow'] }}</strong>
                        <div class="corp-footer-social">
                            @foreach($footerProfiles as $network => $profileUrl)
                                <a href="{{ $profileUrl }}" target="_blank" rel="me noopener noreferrer">{{ ucfirst($network) }} ↗</a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="corp-footer-map-frame">
                <iframe src="{{ $footerMapEmbedUrl }}"
                        title="{{ $footerText['find'] }} — {{ config('website.name') }}"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                        tabindex="-1"></iframe>
            </div>
        </section>

        <div class="corp-footer-bottom">
            <span>© {{ now()->year }} {{ config('website.name') }}. {{ $footerText['rights'] }}</span>
            <div>
                <a href="{{ \App\Support\LocalizedUrl::path('/privacy-policy') }}">{{ __('website.footer.privacy') }}</a>
                <a href="{{ \App\Support\LocalizedUrl::path('/company-facts') }}">{{ __('website.nav.company_facts') }}</a>
                <a href="{{ route('sitemap') }}">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
