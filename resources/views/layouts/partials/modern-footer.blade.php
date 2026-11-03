@php
    use App\Support\LocalizedUrl;

    $mapUrl = 'https://www.google.com/maps/search/?api=1&query=34.5143264%2C69.1840542';
@endphp
<footer class="mx-footer">
    <div class="mx-wrap">
        <div class="mx-footer-grid">
            <div class="mx-footer-brand">
                <p class="mx-footer-name">@include('marketing.templates.modern.partials.logo', ['uid' => 'footer', 'height' => 30, 'light' => true]) <span>{{ config('website.name') }}</span></p>
                <p>{{ __('modern.footer.description') }}</p>
                <ul class="mx-footer-langs">
                    @foreach(config('website.locales') as $code => $language)
                        <li><a href="{{ LocalizedUrl::current($code) }}" hreflang="{{ $language['hreflang'] ?? $code }}" lang="{{ $code }}" @if($code === app()->getLocale()) aria-current="true" @endif>{{ $language['native'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="mx-footer-heading">{{ __('modern.footer.work') }}</p>
                <ul>
                    <li><a href="{{ LocalizedUrl::path('/solutions') }}">{{ __('modern.nav.solutions') }}</a></li>
                    <li><a href="{{ LocalizedUrl::path('/services') }}">{{ __('modern.nav.services') }}</a></li>
                    <li><a href="{{ LocalizedUrl::path('/industries') }}">{{ __('modern.nav.industries') }}</a></li>
                    <li><a href="{{ LocalizedUrl::path('/contact') }}?request=training#contact">{{ __('modern.nav.academy') }}</a></li>
                    <li><a href="{{ LocalizedUrl::path('/request-for-quotation') }}">{{ __('modern.nav.rfq') }}</a></li>
                </ul>
            </div>

            <div>
                <p class="mx-footer-heading">{{ __('modern.footer.products') }}</p>
                <ul>
                    @foreach(config('website.products', []) as $product)
                        <li><a href="{{ LocalizedUrl::path($product['url']) }}">{{ __("website.products.{$product['key']}.name") }}</a></li>
                    @endforeach
                    <li><a href="{{ LocalizedUrl::path('/products') }}">{{ __('modern.nav.all_products') }}</a></li>
                </ul>
            </div>

            <div>
                <p class="mx-footer-heading">{{ __('modern.footer.company') }}</p>
                <ul>
                    <li><a href="{{ LocalizedUrl::path('/about') }}">{{ __('modern.nav.about') }}</a></li>
                    <li><a href="{{ LocalizedUrl::path('/projects') }}">{{ __('modern.nav.projects') }}</a></li>
                    <li><a href="{{ LocalizedUrl::path('/pricing') }}">{{ __('modern.nav.pricing') }}</a></li>
                    <li><a href="{{ LocalizedUrl::path('/articles') }}">{{ __('modern.nav.articles') }}</a></li>
                    <li><a href="{{ LocalizedUrl::path('/company-facts') }}">{{ __('modern.nav.facts') }}</a></li>
                </ul>
            </div>

            <div>
                <p class="mx-footer-heading">{{ __('modern.footer.contact') }}</p>
                <ul>
                    <li><a href="mailto:{{ config('website.email') }}">{{ config('website.email') }}</a></li>
                    <li><a href="tel:{{ config('website.phone') }}" dir="ltr">{{ config('website.phone') }}</a></li>
                    <li><a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer">{{ config('website.address.line') }}, {{ config('website.address.city') }}</a></li>
                </ul>
                @if(config('website.official_profiles'))
                    <p class="mx-footer-heading mx-footer-subheading">{{ __('modern.footer.profiles') }}</p>
                    <ul class="mx-footer-inline">
                        @foreach(config('website.official_profiles') as $network => $profileUrl)
                            <li><a href="{{ $profileUrl }}" target="_blank" rel="me noopener">{{ ucfirst($network) }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="mx-footer-bottom">
            <span>© {{ now()->year }} {{ config('website.name') }}. {{ __('modern.footer.rights') }}</span>
            <a href="{{ LocalizedUrl::path('/privacy-policy') }}">{{ __('modern.footer.privacy') }}</a>
        </div>
    </div>
</footer>
