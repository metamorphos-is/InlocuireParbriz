{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
@foreach ($urls as $u)
    <url>
        <loc>{{ $u['loc'] }}</loc>
@if ($u['lastmod'])
        <lastmod>{{ $u['lastmod'] }}</lastmod>
@endif
        <changefreq>{{ $u['changefreq'] }}</changefreq>
        <priority>{{ $u['priority'] }}</priority>
@foreach (array_unique($u['images'] ?? []) as $slug)
@if ($img = \App\Support\Img::get($slug))
        <image:image><image:loc>{{ rtrim(config('inlocuireparbriz.canonical_url'), '/').'/assets/img/foto/'.$slug.'-1280.webp' }}</image:loc></image:image>
@endif
@endforeach
    </url>
@endforeach
</urlset>
