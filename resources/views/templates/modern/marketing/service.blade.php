@extends('marketing.page')

@section('detail_profile')
    @if($serviceProfile)
        @include('marketing.partials.mx-profile', [
            'title' => __('website.insights.service_profile_title'),
            'facts' => [
                [__('website.insights.service_engagement'), $serviceProfile['engagement']],
                [__('website.insights.service_delivery'), $serviceProfile['delivery']],
                [__('website.insights.service_handover'), $serviceProfile['handover']],
            ],
            'chips' => $serviceProfile['capabilities'],
        ])
    @endif
@endsection
