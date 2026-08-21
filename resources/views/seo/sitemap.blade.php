{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
        @foreach(config('website.locales') as $locale => $language)
            <xhtml:link rel="alternate" hreflang="{{ $locale }}" href="{{ App\Support\LocalizedUrl::path('/', $locale) }}" />
        @endforeach
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
        </url>
    @endforeach
</urlset>
