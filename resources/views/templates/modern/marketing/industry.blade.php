@extends('marketing.page')

@section('detail_profile')
    @if($industryProfile)
        @include('marketing.partials.mx-profile', [
            'title' => __('website.insights.industry_profile_title'),
            'facts' => [
                [__('website.insights.industry_operations'), $industryProfile['operations']],
                [__('website.insights.industry_control'), $industryProfile['control']],
                [__('website.insights.industry_decisions'), $industryProfile['decisions']],
            ],
            'chips' => $industryProfile['capabilities'],
        ])
    @endif
@endsection
