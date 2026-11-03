@extends('layouts.marketing')

@php
    use App\Support\LocalizedUrl;

    $crumbs = [];
    if ($archive) {
        $crumbs[] = [$archive['label'], $archive['path']];
    }
    $crumbs[] = [$page->translation('title'), null];

    $primaryIntent = $callToAction['primary_intent'] ?? 'proposal';
    $primaryParameters = ['interest' => $page->slug];
    if ($primaryIntent !== 'proposal') {
        $primaryParameters['request'] = $primaryIntent;
    }
    $primaryCtaUrl = LocalizedUrl::path('/contact').'?'.http_build_query($primaryParameters).'#contact';

    $secondaryCtaUrl = null;
    if (($callToAction['secondary_label'] ?? '') !== '' && ($callToAction['secondary_intent'] ?? null)) {
        $secondaryCtaUrl = LocalizedUrl::path('/contact').'?'.http_build_query([
            'interest' => $page->slug,
            'request' => $callToAction['secondary_intent'],
        ]).'#contact';
    }

    $hasMeta = ($page->type === 'article' && $page->published_at) || $page->author_name || $page->reviewer_name;
@endphp

@section('content')
@include('marketing.partials.mx-page-hero', [
    'crumbs' => $crumbs,
    'eyebrow' => $page->translation('eyebrow'),
    'title' => $page->translation('title'),
    'summary' => $page->translation('summary'),
    'meta' => $hasMeta ? view('marketing.partials.mx-article-meta', ['page' => $page])->render() : null,
    'actions' => $page->type !== 'article',
    'interest' => $page->slug,
])

@yield('detail_profile')

<section class="mx-section mx-content-section">
    <div class="mx-wrap mx-content-layout">
        <article class="mx-prose">{!! $page->translation('body') !!}</article>
        @include('marketing.partials.mx-cta-card', [
            'heading' => ($callToAction['heading'] ?? '') !== '' ? $callToAction['heading'] : __('website.page.cta_title'),
            'description' => ($callToAction['description'] ?? '') !== '' ? $callToAction['description'] : __('website.page.cta_description'),
            'primaryUrl' => $primaryCtaUrl,
            'primaryLabel' => ($callToAction['primary_label'] ?? '') !== '' ? $callToAction['primary_label'] : __('website.page.cta'),
            'secondaryUrl' => $secondaryCtaUrl,
            'secondaryLabel' => $callToAction['secondary_label'] ?? null,
            'trackLabel' => $page->slug.':'.$primaryIntent,
        ])
    </div>
</section>

@include('marketing.partials.commercial-search-guide')

@include('marketing.partials.mx-faq', ['faqs' => $faqs])

@include('marketing.partials.mx-related', ['relatedPages' => $relatedPages])
@endsection
