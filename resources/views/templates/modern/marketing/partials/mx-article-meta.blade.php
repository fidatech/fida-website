<div class="mx-article-meta">
    @if($page->type === 'article' && $page->published_at)
        <span>{{ __('website.page.published') }} <time datetime="{{ $page->published_at->toDateString() }}">{{ $page->published_at->format('Y-m-d') }}</time></span>
    @endif
    @if($page->articleCategory?->active)
        <a href="{{ App\Support\LocalizedUrl::path('/articles/category/'.$page->articleCategory->slug) }}">{{ $page->articleCategory->translation('name') }}</a>
    @endif
    @if($page->byline())
        @if($page->articleAuthor?->active)
            <a href="{{ App\Support\LocalizedUrl::path('/articles/author/'.$page->articleAuthor->slug) }}">{{ __('website.page.by') }} {{ $page->byline() }}</a>
        @else
            <span>{{ __('website.page.by') }} {{ $page->byline() }}</span>
        @endif
    @endif
    @if($page->reviewer_name)
        <span>{{ __('website.page.reviewed_by') }} {{ $page->reviewer_name }}@if($page->reviewed_at) <time datetime="{{ $page->reviewed_at->toDateString() }}">{{ $page->reviewed_at->format('Y-m-d') }}</time>@endif</span>
    @endif
</div>
