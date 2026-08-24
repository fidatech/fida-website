@extends('marketing.page')

@section('detail_profile')
    @if($industryProfile)
        <section class="industry-profile-section">
            <div class="container industry-profile-shell reveal">
                <div class="industry-profile-intro">
                    <div class="micro-label"><span>IND</span>{{ __('website.insights.industry_profile') }}</div>
                    <h2>{{ __('website.insights.industry_profile_title') }}</h2>
                </div>
                <dl class="industry-profile-facts">
                    @if($industryProfile['operations'])<div><dt>{{ __('website.insights.industry_operations') }}</dt><dd>{{ $industryProfile['operations'] }}</dd></div>@endif
                    @if($industryProfile['control'])<div><dt>{{ __('website.insights.industry_control') }}</dt><dd>{{ $industryProfile['control'] }}</dd></div>@endif
                    @if($industryProfile['decisions'])<div><dt>{{ __('website.insights.industry_decisions') }}</dt><dd>{{ $industryProfile['decisions'] }}</dd></div>@endif
                </dl>
                @if($industryProfile['capabilities'] !== [])
                    <div class="industry-capability-cloud">@foreach($industryProfile['capabilities'] as $capability)<span>{{ $capability }}</span>@endforeach</div>
                @endif
            </div>
        </section>
    @endif
@endsection
