<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = [
            ['loc' => route('home'), 'changefreq' => 'weekly', 'priority' => '1.0'],
        ];

        foreach (array_keys(config('inlocuireparbriz.services')) as $slug) {
            $urls[] = ['loc' => url('/'.$slug), 'changefreq' => 'weekly', 'priority' => '0.8'];
        }

        foreach (\App\Models\City::query()->withPublicPage()->orderBy('sort_order')->get() as $city) {
            $urls[] = ['loc' => $city->url(), 'changefreq' => 'weekly', 'priority' => '0.8', 'images' => \App\Support\Img::forCity($city, (int) $city->sort_order), 'lastmod' => $city->updated_at];
        }

        foreach (range(1, 6) as $n) {
            $urls[] = [
                'loc' => url("/inlocuire-parbriz-bucuresti/sector-{$n}"),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        $urls[] = ['loc' => route('blog.index'), 'changefreq' => 'weekly', 'priority' => '0.6'];
        foreach (\App\Models\Post::query()->published()->orderByDesc('published_at')->get() as $post) {
            $urls[] = ['loc' => $post->url(), 'changefreq' => 'monthly', 'priority' => '0.6', 'images' => [\App\Support\Img::forPost($post)], 'lastmod' => $post->updated_at];
        }

        $urls[] = ['loc' => route('services'), 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('contact'), 'changefreq' => 'monthly', 'priority' => '0.5'];
        $urls[] = ['loc' => route('lead.create'), 'changefreq' => 'monthly', 'priority' => '0.6'];
        $urls[] = ['loc' => url('/despre-noi'), 'changefreq' => 'monthly', 'priority' => '0.4'];

        // Imaginile paginilor fixe (config/images.php) → <image:image>, pentru Google Images.
        foreach ($urls as &$u) {
            $path = parse_url($u['loc'], PHP_URL_PATH) ?: '/';
            $u['images'] ??= \App\Support\Img::forPath($path);
            $u['loc'] = \App\Support\Seo::canonical($path);
            $u['lastmod'] = isset($u['lastmod']) ? \Illuminate\Support\Carbon::parse($u['lastmod'])->toAtomString() : null;
        }
        unset($u);

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
