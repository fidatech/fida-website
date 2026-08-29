@extends('marketing.page')

@section('detail_profile')
    @if($page->articleAuthor?->active || $page->articleCategory?->active)
        <section class="article-editorial-section">
            <div class="container article-editorial-shell reveal">
                @if($page->articleCategory?->active)
                    <a class="article-editorial-category" href="{{ App\Support\LocalizedUrl::path('/articles/category/'.$page->articleCategory->slug) }}"><small>{{ __('website.insights.category') }}</small><strong>{{ $page->articleCategory->translation('name') }}</strong><span>↗</span></a>
                @endif
                @if($page->articleAuthor?->active)
                    <a class="article-editorial-author" href="{{ App\Support\LocalizedUrl::path('/articles/author/'.$page->articleAuthor->slug) }}">
                        <span class="article-author-mark">{{ strtoupper(substr($page->articleAuthor->name, 0, 1)) }}</span>
                        <span><small>{{ $page->articleAuthor->translation('role') ?: __('website.insights.author') }}</small><strong>{{ $page->articleAuthor->name }}</strong></span>
                        <i>↗</i>
                    </a>
                @endif
            </div>
        </section>
    @endif
@endsection
