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

        foreach (range(1, 6) as $n) {
            $urls[] = [
                'loc' => url("/inlocuire-parbriz-bucuresti/sector-{$n}"),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        $urls[] = ['loc' => route('services'), 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('contact'), 'changefreq' => 'monthly', 'priority' => '0.5'];
        $urls[] = ['loc' => route('lead.create'), 'changefreq' => 'monthly', 'priority' => '0.6'];
        $urls[] = ['loc' => url('/despre-noi'), 'changefreq' => 'monthly', 'priority' => '0.4'];

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
