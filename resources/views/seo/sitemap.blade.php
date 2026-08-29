@php echo '<'.'?xml version="1.0" encoding="UTF-8"?'.'>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
    @foreach($entries as $entry)
        <url>
            <loc>{{ App\Support\LocalizedUrl::path($entry['path'], config('website.default_locale')) }}</loc>
            @if($entry['last_modified'])<lastmod>{{ $entry['last_modified']->toAtomString() }}</lastmod>@endif
            @if($entry['change_frequency'])<changefreq>{{ $entry['change_frequency'] }}</changefreq>@endif
            <priority>{{ $entry['priority'] }}</priority>
            @foreach(config('website.locales') as $locale => $language)
                <xhtml:link rel="alternate" hreflang="{{ $language['hreflang'] ?? $locale }}" href="{{ App\Support\LocalizedUrl::path($entry['path'], $locale) }}" />
            @endforeach
            <xhtml:link rel="alternate" hreflang="x-default" href="{{ App\Support\LocalizedUrl::path($entry['path'], config('website.default_locale')) }}" />
        </url>
    @endforeach
</urlset>
