<?php

namespace App\Support;

use App\Models\City;
use Illuminate\Support\Facades\Cache;
use Throwable;

/** Construiește meniul „Locații”: regiunile fixe din config + orașele publicate din admin, grupate pe regiuni. */
final class Navigation
{
    /** @return array<int,array<string,mixed>> */
    public static function locationRegions(): array
    {
        $fixed = config('navigation.locatii.regions');
        $byKey = collect($fixed)->keyBy('key');

        try {
            $cities = Cache::remember('nav:cities:v1', 600, fn () => City::query()->withPublicPage()
                ->orderBy('sort_order')->orderBy('name')
                ->get(['name', 'slug', 'region', 'county'])
                ->map(fn ($c) => ['name' => $c->name, 'slug' => $c->slug, 'region' => $c->region, 'county' => $c->county])
                ->all());
        } catch (Throwable) {
            $cities = [];
        }

        $regions = [$byKey['bucuresti'], $byKey['ilfov']];
        $icons = ['transilvania' => 'map', 'banat-crisana' => 'map', 'moldova' => 'map', 'muntenia' => 'map', 'oltenia' => 'map', 'dobrogea' => 'map'];

        foreach (City::REGIONS as $key => $label) {
            $items = array_values(array_filter($cities, fn ($c) => $c['region'] === $key));
            if ($key === 'bucuresti-ilfov' || ! $items) {
                continue;
            }
            $regions[] = [
                'key' => $key,
                'label' => $label,
                'icon' => $icons[$key] ?? 'map',
                'title' => "Înlocuire parbriz în {$label}",
                'description' => 'Trimite cererea din orașul tău — îți confirmăm disponibilitatea unui atelier partener din zonă.',
                'main' => ['label' => 'Cere ofertă din '.$label, 'url' => '/cerere-oferta?zona=alt_oras'],
                'items' => array_map(fn ($c) => [
                    'label' => $c['name'],
                    'hint' => $c['county'] && $c['county'] !== $c['name'] ? 'județul '.$c['county'] : 'Parbrize '.$c['name'],
                    'url' => '/inlocuire-parbriz-'.$c['slug'],
                    'title' => 'Parbrize '.$c['name'],
                ], $items),
            ];
        }

        $regions[] = $byKey['alte'];

        return $regions;
    }

    public static function forget(): void
    {
        Cache::forget('nav:cities:v1');
        Cache::forget('home:cities:v1');
    }
}
