{{-- Bottom strip shared by the mega-menus. Params: allHref, allLabel (optional). --}}
<div class="mx-mega-foot">
    <p><span>{{ __('modern.menu.help') }}</span> <a href="{{ \App\Support\LocalizedUrl::path('/contact') }}#contact" data-track-event="cta_click" data-track-label="mega_menu_help">{{ __('modern.menu.help_link') }}</a></p>
    <p class="mx-mega-direct">
        <a href="mailto:{{ config('website.email') }}">{{ config('website.email') }}</a>
        <a href="https://wa.me/{{ config('website.whatsapp') }}" rel="noopener" dir="ltr">{{ config('website.phone') }}</a>
    </p>
    @if(! empty($allHref))
        <a class="mx-mega-all" href="{{ $allHref }}">{{ $allLabel }} {!! \App\Support\ModernIcons::svg('arrow', 15) !!}</a>
    @endif
</div>
