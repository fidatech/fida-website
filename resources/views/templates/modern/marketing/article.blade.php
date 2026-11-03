@extends('marketing.page')

@section('detail_profile')
    @if($page->articleAuthor?->active || $page->articleCategory?->active)
        <section class="mx-profile-section">
            <div class="mx-wrap mx-editorial">
                @if($page->articleCategory?->active)
                    <a class="mx-editorial-card" href="{{ App\Support\LocalizedUrl::path('/articles/category/'.$page->articleCategory->slug) }}">
                        <small>{{ __('website.insights.category') }}</small>
                        <strong>{{ $page->articleCategory->translation('name') }}</strong>
                    </a>
                @endif
                @if($page->articleAuthor?->active)
                    <a class="mx-editorial-card mx-editorial-author" href="{{ App\Support\LocalizedUrl::path('/articles/author/'.$page->articleAuthor->slug) }}">
                        <span aria-hidden="true">{{ mb_strtoupper(mb_substr($page->articleAuthor->name, 0, 1)) }}</span>
                        <span><small>{{ $page->articleAuthor->translation('role') ?: __('website.insights.author') }}</small><strong>{{ $page->articleAuthor->name }}</strong></span>
                    </a>
                @endif
            </div>
        </section>
    @endif
@endsection
