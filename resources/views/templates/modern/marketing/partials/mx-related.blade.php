@if(isset($relatedPages) && $relatedPages->isNotEmpty())
<section class="mx-section">
    <div class="mx-wrap">
        <header class="mx-section-head">
            <h2>{{ __('website.page.related_title') }}</h2>
        </header>
        <div class="mx-card-grid">
            @foreach($relatedPages as $relatedPage)
                <a class="mx-card" href="{{ App\Support\LocalizedUrl::path('/'.$relatedPage->slug) }}">
                    <span class="mx-card-type">{{ config("website.content_types.{$relatedPage->type}.singular", Str::headline($relatedPage->type)) }}</span>
                    <h3>{{ $relatedPage->translation('title') }}</h3>
                    <p>{{ $relatedPage->translation('summary') }}</p>
                    @if($relatedPage->type === 'article' && ($relatedPage->articleCategory || $relatedPage->byline()))
                        <small>{{ $relatedPage->articleCategory?->translation('name') }}@if($relatedPage->articleCategory && $relatedPage->byline()), @endif{{ $relatedPage->byline() }}</small>
                    @endif
                    <b>{{ __('website.solutions.learn_more') }}</b>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
