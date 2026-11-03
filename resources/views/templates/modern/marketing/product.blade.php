@extends('marketing.page')

@section('detail_profile')
    @if($productProfile)
        @include('marketing.partials.mx-profile', [
            'title' => __('website.page.product_profile'),
            'code' => $productProfile['code'],
            'facts' => [
                [__('website.page.product_category'), $productProfile['category']],
                [__('website.page.product_platform'), $productProfile['platform']],
                [__('website.page.product_deployment'), $productProfile['deployment']],
                [__('website.page.product_status'), $productProfile['status']],
            ],
            'chips' => $productProfile['features'],
        ])
    @endif
@endsection
