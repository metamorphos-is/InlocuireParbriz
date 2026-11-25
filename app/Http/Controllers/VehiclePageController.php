<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\VehiclePage;
use Illuminate\View\View;

class VehiclePageController extends Controller
{
    public function index(): View
    {
        $brands = VehiclePage::query()->brands()->published()->orderBy('sort_order')->orderBy('brand_name')->get();
        $models = VehiclePage::query()->models()->published()->orderBy('sort_order')->orderBy('model_name')->get()->groupBy('brand_slug');

        return view('pages.vehicles.index', [
            'brands' => $brands->filter(fn ($b) => $models->has($b->brand_slug))->values(),
            'models' => $models,
        ]);
    }

    public function brand(string $brand): View
    {
        $page = VehiclePage::query()->brands()->published()->where('brand_slug', $brand)->firstOrFail();
        $models = VehiclePage::query()->models()->published()->where('brand_slug', $brand)->orderBy('sort_order')->orderBy('model_name')->get();
        abort_if($models->isEmpty(), 404); // fără modele publicate, pagina de marcă ar fi subțire

        return view('pages.vehicles.brand', [
            'page' => $page,
            'models' => $models,
            'otherBrands' => VehiclePage::query()->brands()->published()->where('id', '!=', $page->id)->orderBy('sort_order')->get(),
        ]);
    }

    public function model(string $brand, string $model): View
    {
        $page = VehiclePage::query()->models()->published()->where('brand_slug', $brand)->where('model_slug', $model)->firstOrFail();
        $brandPage = VehiclePage::query()->brands()->where('brand_slug', $brand)->first();

        return view('pages.vehicles.model', [
            'page' => $page,
            'brandPage' => $brandPage,
            'siblings' => VehiclePage::query()->models()->published()->where('brand_slug', $brand)->where('id', '!=', $page->id)->orderBy('sort_order')->get(),
            'cities' => City::query()->withPublicPage()->orderBy('sort_order')->limit(8)->get(['name', 'slug']),
        ]);
    }
}
