<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Support\Facades\Cache;
use Throwable;

class HomeController extends Controller
{
    public function __invoke()
    {
        try {
            // Doar valori simple în cache (Laravel 13 nu deserializează modele din cache).
            $cities = Cache::remember('home:cities:v1', 600, fn () => City::query()->withPublicPage()
                ->orderBy('sort_order')->orderBy('name')
                ->get(['name', 'slug', 'region'])
                ->map(fn ($c) => ['name' => $c->name, 'slug' => $c->slug, 'region' => $c->region])
                ->all());
        } catch (Throwable) {
            $cities = [];
        }

        $regions = [];
        foreach (City::REGIONS as $key => $label) {
            $items = array_values(array_filter($cities, fn ($c) => $c['region'] === $key));
            if ($key === 'bucuresti-ilfov') {
                array_unshift($items, ['name' => 'București', 'slug' => 'bucuresti'], ['name' => 'Ilfov', 'slug' => 'ilfov']);
            }
            if ($items) {
                $regions[$key] = ['label' => $label, 'items' => $items];
            }
        }

        return view('pages.home', [
            'regions' => $regions,
            'cityCount' => count($cities) + 1,
        ]);
    }
}
