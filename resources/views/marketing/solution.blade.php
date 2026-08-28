@extends('marketing.page')

@section('detail_profile')
    @if($solutionProfile)
        <section class="industry-profile-section solution-profile-section">
            <div class="container industry-profile-shell reveal">
                <div class="industry-profile-intro">
                    <div class="micro-label"><span>SOL</span>{{ __('website.insights.solution_profile') }}</div>
                    <h2>{{ __('website.insights.solution_profile_title') }}</h2>
                </div>
                <dl class="industry-profile-facts">
                    @if($solutionProfile['outcomes'])<div><dt>{{ __('website.insights.solution_outcomes') }}</dt><dd>{{ $solutionProfile['outcomes'] }}</dd></div>@endif
                    @if($solutionProfile['control'])<div><dt>{{ __('website.insights.solution_control') }}</dt><dd>{{ $solutionProfile['control'] }}</dd></div>@endif
                    @if($solutionProfile['decisions'])<div><dt>{{ __('website.insights.solution_decisions') }}</dt><dd>{{ $solutionProfile['decisions'] }}</dd></div>@endif
                </dl>
                @if($solutionProfile['capabilities'] !== [])
                    <div class="industry-capability-cloud">@foreach($solutionProfile['capabilities'] as $capability)<span>{{ $capability }}</span>@endforeach</div>
                @endif
            </div>
        </section>
    @endif
@endsection
