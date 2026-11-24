<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CityPageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\SeoPageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

$seoSlugs = [
    'inlocuire-parbriz-bucuresti',
    'inlocuire-parbriz-la-domiciliu',
    'pret-inlocuire-parbriz',
    'reparatie-parbriz',
    'calibrare-adas',
    'parbriz-pe-casco',
    'inlocuire-parbriz-ilfov',
    'parbrize-flote-firme',
    'inlocuire-luneta-si-geamuri-laterale',
    'despre-noi',
];

Route::get('/{slug}', [SeoPageController::class, 'show'])
    ->whereIn('slug', $seoSlugs)
    ->name('seo.page');

Route::get('/inlocuire-parbriz-bucuresti/sector-{n}', [SeoPageController::class, 'sector'])
    ->whereNumber('n')
    ->name('seo.sector');

// Pagini de oraș (din admin → Orașe). București și Ilfov au paginile lor dedicate, definite mai sus.
Route::get('/inlocuire-parbriz-{city}', [CityPageController::class, 'show'])
    ->where('city', '(?!bucuresti$|ilfov$|la-domiciliu$)[a-z0-9-]+')
    ->name('city.show');

Route::view('/servicii', 'pages.services')->name('services');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->where('slug', '[a-z0-9-]+')->name('blog.show');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::get('/politica-de-confidentialitate', [ContactController::class, 'privacy'])->name('privacy');
Route::redirect('/politica-confidentialitate', '/politica-de-confidentialitate');

Route::get('/cerere-oferta', [LeadController::class, 'create'])->name('lead.create');
Route::post('/cerere-oferta', [LeadController::class, 'store'])->middleware('throttle:6,1')->name('lead.store');
Route::get('/cerere-oferta/multumim', [LeadController::class, 'thanks'])->name('lead.thanks');
Route::redirect('/solicita-oferta', '/cerere-oferta');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
