<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\View\View;

class CityPageController extends Controller
{
    public function show(string $city): View
    {
        $model = City::query()->withPublicPage()->where('slug', $city)->firstOrFail();

        $nearby = City::query()->withPublicPage()
            ->where('region', $model->region)->where('id', '!=', $model->id)
            ->orderBy('sort_order')->limit(6)->get();

        return view('pages.city', ['city' => $model, 'nearby' => $nearby]);
    }
}
