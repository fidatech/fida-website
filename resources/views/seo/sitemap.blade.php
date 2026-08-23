@php echo '<'.'?xml version="1.0" encoding="UTF-8"?'.'>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
        @foreach(config('website.locales') as $locale => $language)
            <xhtml:link rel="alternate" hreflang="{{ $locale }}" href="{{ App\Support\LocalizedUrl::path('/', $locale) }}" />
        @endforeach
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ App\Support\LocalizedUrl::path('/', config('website.default_locale')) }}" />
    </url>
    @foreach($pages as $page)
        <url>
            <loc>{{ url('/'.$page->slug) }}</loc>
            <lastmod>{{ $page->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
            @foreach(config('website.locales') as $locale => $language)
                <xhtml:link rel="alternate" hreflang="{{ $locale }}" href="{{ App\Support\LocalizedUrl::path('/'.$page->slug, $locale) }}" />
            @endforeach
            <xhtml:link rel="alternate" hreflang="x-default" href="{{ App\Support\LocalizedUrl::path('/'.$page->slug, config('website.default_locale')) }}" />
        </url>
    @endforeach
    @foreach($articleCategories as $articleCategory)
        <url>
            <loc>{{ url('/articles/category/'.$articleCategory->slug) }}</loc>
            <lastmod>{{ $articleCategory->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.6</priority>
            @foreach(config('website.locales') as $locale => $language)
                <xhtml:link rel="alternate" hreflang="{{ $locale }}" href="{{ App\Support\LocalizedUrl::path('/articles/category/'.$articleCategory->slug, $locale) }}" />
            @endforeach
            <xhtml:link rel="alternate" hreflang="x-default" href="{{ App\Support\LocalizedUrl::path('/articles/category/'.$articleCategory->slug, config('website.default_locale')) }}" />
        </url>
    @endforeach
    @foreach($articleAuthors as $articleAuthor)
        <url>
            <loc>{{ url('/articles/author/'.$articleAuthor->slug) }}</loc>
            <lastmod>{{ $articleAuthor->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.5</priority>
            @foreach(config('website.locales') as $locale => $language)
                <xhtml:link rel="alternate" hreflang="{{ $locale }}" href="{{ App\Support\LocalizedUrl::path('/articles/author/'.$articleAuthor->slug, $locale) }}" />
            @endforeach
            <xhtml:link rel="alternate" hreflang="x-default" href="{{ App\Support\LocalizedUrl::path('/articles/author/'.$articleAuthor->slug, config('website.default_locale')) }}" />
        </url>
    @endforeach
</urlset>
