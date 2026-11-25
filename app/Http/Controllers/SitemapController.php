<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

/**
 * Sitemap XML simplu și curat: doar paginile indexabile + <lastmod>.
 * Fără <image:image> (Google găsește imaginile în pagini). Cu <changefreq> și <priority> pe tipul paginii
 * (Google le ignoră, dar Bing, Yandex și uneltele SEO le folosesc ca semnal de importanță relativă).
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
        try {
            $models = \App\Models\VehiclePage::query()->models()->published()->get();
        } catch (\Throwable) {
            $models = collect(); // tabelul apare abia după migrare; sitemap-ul nu trebuie să cadă între deploy și migrare
        }
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
            [$priority, $changefreq] = self::rank($path);
            $clean[] = [
                'loc' => $loc,
                'lastmod' => Carbon::parse($u['lastmod'])->toAtomString(),
                'changefreq' => $changefreq,
                'priority' => $priority,
            ];
        }

        return response()
            ->view('sitemap', ['urls' => $clean])
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=900');
    }

    /**
     * Prioritate și frecvență pe tipul paginii, după cale: orice pagină nouă (inclusiv cele publicate
     * automat din coadă) primește valoarea tipului ei fără altă configurare.
     *
     * @return array{0: string, 1: string} [priority, changefreq]
     */
    public static function rank(string $path): array
    {
        $path = '/'.trim($path, '/');
        $services = array_map(fn ($s) => '/'.$s, array_keys(config('inlocuireparbriz.services', [])));

        return match (true) {
            $path === '/' => ['1.0', 'daily'],
            in_array($path, $services, true), $path === '/servicii' => ['0.9', 'weekly'],
            $path === '/cerere-oferta' => ['0.8', 'monthly'],
            str_starts_with($path, '/inlocuire-parbriz-bucuresti/sector-') => ['0.7', 'weekly'],
            str_starts_with($path, '/inlocuire-parbriz-') => ['0.8', 'weekly'], // orașe
            $path === '/parbriz-auto' => ['0.8', 'daily'],
            substr_count($path, '/') === 2 && str_starts_with($path, '/parbriz-auto/') => ['0.7', 'monthly'], // modele
            str_starts_with($path, '/parbriz-auto/') => ['0.7', 'weekly'], // mărci
            $path === '/blog' => ['0.7', 'daily'],
            str_starts_with($path, '/blog/') => ['0.6', 'monthly'],
            $path === '/intrebari-frecvente' => ['0.6', 'monthly'],
            $path === '/contact' => ['0.5', 'monthly'],
            $path === '/despre-noi' => ['0.4', 'monthly'],
            default => ['0.3', 'yearly'], // politica de confidențialitate și alte pagini legale
        };
    }
}
