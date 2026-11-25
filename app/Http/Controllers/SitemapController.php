<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

/**
 * Sitemap XML simplu și curat: doar paginile indexabile + <lastmod>.
 * Fără <image:image> (Google găsește imaginile în pagini) și fără changefreq/priority (ignorate de Google).
 */
class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        // Data ultimei publicări a codului: folosită pentru paginile fixe (servicii, contact etc.).
        $deployedAt = Carbon::createFromTimestamp(max(
            @filemtime(base_path('routes/web.php')) ?: 0,
            @filemtime(base_path('config/inlocuireparbriz.php')) ?: 0,
        ) ?: time());

        $urls = [['loc' => route('home'), 'lastmod' => $deployedAt]];

        foreach (array_keys(config('inlocuireparbriz.services')) as $slug) {
            $urls[] = ['loc' => url('/'.$slug), 'lastmod' => $deployedAt];
        }

        foreach (\App\Models\City::query()->withPublicPage()->orderBy('sort_order')->get() as $city) {
            $urls[] = ['loc' => $city->url(), 'lastmod' => $city->updated_at ?? $deployedAt];
        }

        foreach (range(1, 6) as $n) {
            $urls[] = ['loc' => url("/inlocuire-parbriz-bucuresti/sector-{$n}"), 'lastmod' => $deployedAt];
        }

        $posts = \App\Models\Post::query()->published()->orderByDesc('published_at')->get();
        $urls[] = ['loc' => route('blog.index'), 'lastmod' => $posts->max('updated_at') ?? $deployedAt];
        foreach ($posts as $post) {
            $urls[] = ['loc' => $post->url(), 'lastmod' => $post->updated_at ?? $post->published_at ?? $deployedAt];
        }

        // Parbriz pe marcă și model: hub, mărci (doar cu modele publicate) și modele.
        $models = \App\Models\VehiclePage::query()->models()->published()->get();
        if ($models->isNotEmpty()) {
            $urls[] = ['loc' => route('vehicles.index'), 'lastmod' => max($models->max('updated_at'), $deployedAt)];
            $brands = \App\Models\VehiclePage::query()->brands()->published()->whereIn('brand_slug', $models->pluck('brand_slug')->unique())->get();
            foreach ($brands as $b) {
                $latest = $models->where('brand_slug', $b->brand_slug)->max('updated_at');
                $urls[] = ['loc' => $b->url(), 'lastmod' => max($latest, $b->updated_at)];
            }
            foreach ($models->sortByDesc('published_at') as $m) {
                $urls[] = ['loc' => $m->url(), 'lastmod' => $m->updated_at ?? $m->published_at ?? $deployedAt];
            }
        }

        $urls[] = ['loc' => route('faq'), 'lastmod' => max($deployedAt, Carbon::createFromTimestamp(@filemtime(config_path('faq.php')) ?: 0), $posts->max('updated_at') ?? $deployedAt)];
        $urls[] = ['loc' => route('services'), 'lastmod' => $deployedAt];
        $urls[] = ['loc' => route('contact'), 'lastmod' => $deployedAt];
        $urls[] = ['loc' => route('lead.create'), 'lastmod' => $deployedAt];
        $urls[] = ['loc' => url('/despre-noi'), 'lastmod' => $deployedAt];
        $urls[] = ['loc' => route('privacy'), 'lastmod' => $deployedAt];

        $seen = [];
        $clean = [];
        foreach ($urls as $u) {
            $path = parse_url($u['loc'], PHP_URL_PATH) ?: '/';
            $loc = \App\Support\Seo::canonical($path);
            if (isset($seen[$loc])) {
                continue; // fără duplicate
            }
            $seen[$loc] = true;
            $clean[] = ['loc' => $loc, 'lastmod' => Carbon::parse($u['lastmod'])->toAtomString()];
        }

        return response()
            ->view('sitemap', ['urls' => $clean])
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=900');
    }
}
