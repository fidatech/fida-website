@extends('marketing.page')

@section('detail_profile')
    @if($solutionProfile)
        @include('marketing.partials.mx-profile', [
            'title' => __('website.insights.solution_profile_title'),
            'facts' => [
                [__('website.insights.solution_outcomes'), $solutionProfile['outcomes']],
                [__('website.insights.solution_control'), $solutionProfile['control']],
                [__('website.insights.solution_decisions'), $solutionProfile['decisions']],
            ],
            'chips' => $solutionProfile['capabilities'],
        ])
    @endif
@endsection
