{{-- One mega-menu link. Params: href, title, icon (optional), description (optional), current (bool), variant ('rich'|'compact'). --}}
@php($variant = $variant ?? (empty($description) ? 'compact' : 'rich'))
<li>
    <a class="mx-item mx-item-{{ $variant }}" href="{{ $href }}" @if(! empty($current)) aria-current="page" @endif @if(! empty($track)) data-track-event="nav_click" data-track-label="{{ $track }}" @endif>
        @if(! empty($icon))
            <span class="mx-item-icon">{!! \App\Support\ModernIcons::svg($icon, $variant === 'rich' ? 20 : 17) !!}</span>
        @endif
        <span class="mx-item-text">
            <span class="mx-item-title">{{ $title }}</span>
            @if(! empty($description))<span class="mx-item-desc">{{ $description }}</span>@endif
        </span>
    </a>
</li>
