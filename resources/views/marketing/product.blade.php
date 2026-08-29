@extends('marketing.page')

@section('detail_profile')
    @if($productProfile)
        <section class="product-profile-section" style="--product-accent: {{ $productProfile['accent'] }}">
            <div class="container product-profile-shell reveal">
                <div class="product-profile-core" aria-hidden="true">
                    <span>{{ $productProfile['code'] }}</span>
                    <div class="product-profile-orbit product-profile-orbit-one"></div>
                    <div class="product-profile-orbit product-profile-orbit-two"></div>
                    <i></i><i></i><i></i>
                </div>
                <div class="product-profile-data">
                    <div class="micro-label"><span>SYS</span>{{ __('website.page.product_profile') }}</div>
                    <dl>
                        <div><dt>{{ __('website.page.product_category') }}</dt><dd>{{ $productProfile['category'] }}</dd></div>
                        <div><dt>{{ __('website.page.product_platform') }}</dt><dd>{{ $productProfile['platform'] }}</dd></div>
                        <div><dt>{{ __('website.page.product_deployment') }}</dt><dd>{{ $productProfile['deployment'] }}</dd></div>
                        <div><dt>{{ __('website.page.product_status') }}</dt><dd>{{ $productProfile['status'] }}</dd></div>
                    </dl>
                    <div class="product-feature-cloud">
                        @foreach($productProfile['features'] as $feature)<span>{{ $feature }}</span>@endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
