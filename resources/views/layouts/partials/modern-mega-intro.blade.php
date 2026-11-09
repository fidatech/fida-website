{{-- Featured intro card shown at the start of each mega-menu. Params: key, href. --}}
<aside class="mx-mega-intro">
    <span class="mx-mega-kicker">{{ __("modern.menu.{$key}.kicker") }}</span>
    <p class="mx-mega-title">{{ __("modern.menu.{$key}.title") }}</p>
    <p class="mx-mega-text">{{ __("modern.menu.{$key}.text") }}</p>
    <a class="mx-mega-cta" href="{{ $href }}">{{ __("modern.menu.{$key}.cta") }} {!! \App\Support\ModernIcons::svg('arrow', 16) !!}</a>
</aside>
