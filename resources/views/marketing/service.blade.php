@extends('marketing.page')

@section('detail_profile')
    @if($serviceProfile)
        <section class="service-profile-section">
            <div class="container service-profile-shell reveal">
                <div class="service-profile-intro">
                    <div class="micro-label"><span>SVC</span>{{ __('website.insights.service_profile') }}</div>
                    <h2>{{ __('website.insights.service_profile_title') }}</h2>
                </div>
                <dl class="service-profile-facts">
                    @if($serviceProfile['engagement'])<div><dt>{{ __('website.insights.service_engagement') }}</dt><dd>{{ $serviceProfile['engagement'] }}</dd></div>@endif
                    @if($serviceProfile['delivery'])<div><dt>{{ __('website.insights.service_delivery') }}</dt><dd>{{ $serviceProfile['delivery'] }}</dd></div>@endif
                    @if($serviceProfile['handover'])<div><dt>{{ __('website.insights.service_handover') }}</dt><dd>{{ $serviceProfile['handover'] }}</dd></div>@endif
                </dl>
                @if($serviceProfile['capabilities'] !== [])
                    <div class="service-capability-cloud">@foreach($serviceProfile['capabilities'] as $capability)<span>{{ $capability }}</span>@endforeach</div>
                @endif
            </div>
        </section>
    @endif
@endsection
