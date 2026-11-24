<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\CitySector;
use Illuminate\View\View;

class SeoPageController extends Controller
{
    /** Pagini care nu sunt în catalogul `services` (ex. Despre noi). */
    protected array $staticPages = [
        'despre-noi' => [
            'name' => 'Despre noi',
            'h1' => 'Despre inlocuireparbriz.ro',
            'title' => 'Despre noi și cum funcționează | inlocuireparbriz.ro',
            'meta' => 'Cum funcționează inlocuireparbriz.ro: preluăm cererea, identificăm sticla potrivită și o trimitem unui atelier partener verificat din zona ta.',
            'intro' => 'inlocuireparbriz.ro te ajută să rezolvi rapid un parbriz, o lunetă sau un geam lateral deteriorat. Primești oferta și montajul prin atelierele partenere verificate din orașul tău: noi preluăm cererea, verificăm ce sticlă se potrivește mașinii și o trimitem atelierului potrivit din zona ta.',
            'items' => [
                'Identificăm sticla după datele reale ale mașinii',
                'Îți comunicăm oferta înainte de programare',
                'Organizarea montajului la adresă sau în spațiu potrivit',
                'Explicații clare despre senzori, cameră și timpul de după lipire',
            ],
            'sections' => [
                ['Cum tratăm fiecare solicitare', 'Primești o cerere, verificăm marca, modelul, anul și tipul de geam, apoi revenim cu o ofertă. Dacă lipseau date importante, te întrebăm înainte să propunem o sticlă greșită.'],
                ['Ce contează la o lucrare corectă', 'Pregătirea canalului de lipire, poziționarea exactă, adezivul potrivit și timpul de așteptare. Preferăm să amânăm o intervenție decât să lipim într-un loc sau pe o vreme care compromite rezultatul.'],
                ['Cine face lucrarea', 'Montajul și reparațiile sunt făcute de ateliere partenere verificate, cu experiență în sticlă auto. Noi coordonăm cererea: verificăm datele mașinii, alegem atelierul potrivit din zona ta și urmărim ca oferta să ajungă la tine.'],
                ['Transparență', 'Nu publicăm prețuri inventate, nu inventăm parteneriate cu asigurători și nu pretindem ateliere acolo unde nu avem. În București și Ilfov lucrăm deja; pentru alte orașe îți confirmăm disponibilitatea odată cu oferta.'],
            ],
            'faq' => [
                ['Cine îmi face montajul?', 'Un atelier partener verificat din zona ta. Echipa inlocuireparbriz.ro preia cererea, verifică detaliile mașinii și o transmite atelierului potrivit, care îți face oferta și lucrarea.'],
                ['Unde lucrați?', 'În București (sectoarele 1–6) și Ilfov. Pentru alte orașe din țară, trimite cererea: îți confirmăm disponibilitatea unui atelier partener în zona ta înainte de orice angajament.'],
                ['Cum încep?', 'Din pagina „Cere ofertă”: trimite detaliile mașinii și, dacă poți, o fotografie cu avaria.'],
            ],
        ],
    ];

    public function show(string $slug): View
    {
        $service = config("inlocuireparbriz.services.{$slug}");
        $static = $this->staticPages[$slug] ?? null;
        abort_unless($service || $static, 404);

        $page = $service ?? $static;

        $titleOverrides = [
            'inlocuire-parbriz-bucuresti' => 'Înlocuire parbriz București – montaj la atelier sau acasă | inlocuireparbriz.ro',
            'inlocuire-parbriz-la-domiciliu' => 'Înlocuire parbriz la domiciliu în București – montaj mobil | inlocuireparbriz.ro',
            'reparatie-parbriz' => 'Reparație parbriz ciobit sau fisurat – evaluare și ofertă | inlocuireparbriz.ro',
            'pret-inlocuire-parbriz' => 'Cât costă înlocuirea unui parbriz? Preț după mașină | inlocuireparbriz.ro',
            'calibrare-adas' => 'Calibrare ADAS după schimbarea parbrizului | inlocuireparbriz.ro',
            'parbriz-pe-casco' => 'Înlocuire parbriz prin CASCO – pași și documente | inlocuireparbriz.ro',
            'parbrize-flote-firme' => 'Parbrize pentru flote și firme – ofertă pentru companii | inlocuireparbriz.ro',
            'inlocuire-luneta-si-geamuri-laterale' => 'Înlocuire lunetă și geamuri laterale | inlocuireparbriz.ro',
            'inlocuire-parbriz-ilfov' => 'Înlocuire parbriz Ilfov – disponibilitate pe localitate | inlocuireparbriz.ro',
        ];

        $meta = [
            'title' => $titleOverrides[$slug]
                ?? ($page['title'] ?? null)
                ?? (($page['h1'] ?? $page['name']).' | inlocuireparbriz.ro'),
            'description' => $page['meta'] ?? ($page['short'] ?? ''),
            'h1' => $page['h1'] ?? $page['name'],
        ];

        $ctaMap = [
            'reparatie-parbriz' => ['Trimite o fotografie cu avaria', 'Evaluăm dacă se poate repara sau e nevoie de înlocuire.'],
            'inlocuire-parbriz-la-domiciliu' => ['Solicită montaj la domiciliu', 'Spune-ne adresa și detaliile mașinii; confirmăm dacă locația permite.'],
            'inlocuire-luneta-si-geamuri-laterale' => ['Ai nevoie de o lunetă nouă?', 'Precizează tipul de geam și datele mașinii pentru ofertă.'],
            'parbrize-flote-firme' => ['Cere o ofertă pentru flota ta', 'Trimite lista de vehicule sau începe cu prima mașină.'],
            'parbriz-pe-casco' => ['Pregătește dosarul cu o ofertă clară', 'Îți comunicăm oferta pe care o poți folosi în relația cu asigurătorul.'],
            'pret-inlocuire-parbriz' => ['Află prețul pentru mașina ta', 'Fără tarife generice — oferta se face după datele reale.'],
            'inlocuire-parbriz-ilfov' => ['Verifică disponibilitatea în Ilfov', 'Scrie localitatea și detaliile mașinii.'],
            'calibrare-adas' => ['Întreabă despre ADAS pe mașina ta', 'Îți spunem ce se aplică după analiza modelului.'],
        ];

        return view('pages.seo-landing', [
            'slug' => $slug,
            'meta' => $meta,
            'page' => $page,
            'cta' => $ctaMap[$slug] ?? ['Cere o ofertă', 'Trimite detaliile mașinii pentru identificarea geamului potrivit.'],
            'sectors' => CitySector::query()
                ->whereHas('city', fn ($q) => $q->where('slug', 'bucuresti'))
                ->orderBy('slug')
                ->get(),
        ]);
    }

    public function sector(int $n): View
    {
        abort_unless($n >= 1 && $n <= 6, 404);

        $city = City::query()->where('slug', 'bucuresti')->first();
        $sector = $city
            ? CitySector::query()->where('city_id', $city->id)->where('slug', "sector-{$n}")->first()
            : null;

        $local = config("inlocuireparbriz.sector_pages.{$n}", []);
        $areas = $local['areas'] ?? [];
        $areasText = $areas ? implode(', ', array_slice($areas, 0, 4)) : '';

        return view('pages.seo-sector', [
            'n' => $n,
            'sector' => $sector,
            'local' => $local,
            'meta' => [
                'title' => "Înlocuire parbriz Sectorul {$n}, București | inlocuireparbriz.ro",
                'description' => "Înlocuire parbriz în Sectorul {$n}, București".($areasText ? " ({$areasText})" : '').'. Trimite detaliile mașinii și solicită ofertă.',
                'h1' => "Înlocuire parbriz în Sectorul {$n}",
            ],
        ]);
    }
}
