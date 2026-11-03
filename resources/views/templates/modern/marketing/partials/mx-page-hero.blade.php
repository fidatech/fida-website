{{--
    Inner-page hero for the Fida 2026 template.
    $crumbs: list of [label, url|null]; the last one is the current page.
    Optional: $eyebrow, $summary, $meta (HTML-safe slot rendered below the summary), $actions (bool), $interest.
--}}
@php
    use App\Support\LocalizedUrl;
    $interest = $interest ?? null;
    $proposalUrl = LocalizedUrl::path('/contact').($interest ? '?'.http_build_query(['interest' => $interest]) : '').'#contact';
@endphp
<section class="mx-page-hero">
    <div class="mx-wrap">
        <nav class="mx-crumbs" aria-label="{{ __('website.page.breadcrumbs') }}">
            <a href="{{ LocalizedUrl::path('/') }}">{{ __('website.page.home') }}</a>
            @foreach($crumbs as [$label, $url])
                <span aria-hidden="true">/</span>
                @if($url && ! $loop->last)
                    <a href="{{ $url }}">{{ $label }}</a>
                @else
                    <span aria-current="page">{{ $label }}</span>
                @endif
            @endforeach
        </nav>
        @if(filled($eyebrow ?? null))
            <p class="mx-page-eyebrow">{{ $eyebrow }}</p>
        @endif
        <h1>{{ $title }}</h1>
        @if(filled($summary ?? null))
            <p class="mx-page-summary">{{ $summary }}</p>
        @endif
        @isset($meta)
            {!! $meta !!}
        @endisset
        @if($actions ?? false)
            <div class="mx-actions">
                <a class="mx-button mx-button-primary" href="{{ $proposalUrl }}" data-track-event="cta_click" data-track-label="hero:{{ $interest ?? 'page' }}">{{ __('modern.nav.cta') }}</a>
                <a class="mx-button mx-button-light" href="{{ LocalizedUrl::path('/request-for-quotation') }}">{{ __('modern.nav.rfq') }}</a>
            </div>
        @endif
    </div>
</section>
