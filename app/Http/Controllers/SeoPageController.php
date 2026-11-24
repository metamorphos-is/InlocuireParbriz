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
            'h1' => 'Despre Înlocuire Parbriz',
            'title' => 'Despre Înlocuire Parbriz | Sticlă auto București',
            'meta' => 'Cine suntem și cum lucrăm: identificare parbriz, ofertă clară și montaj organizat în București.',
            'intro' => 'Înlocuire Parbriz este dedicat șoferilor din București care au nevoie de un parbriz, o lunetă sau un geam lateral schimbat corect. Nu vindem povești despre „soluții integrate” — îți explicăm ce sticlă se potrivește mașinii tale și ce presupune montajul, înainte să înceapă lucrarea.',
            'items' => [
                'Identificăm sticla după datele reale ale mașinii',
                'Îți comunicăm oferta înainte de programare',
                'Organizarea montajului la adresă sau în spațiu potrivit',
                'Explicații clare despre senzori, cameră și timpul de după lipire',
            ],
            'sections' => [
                ['Cum tratăm fiecare solicitare', 'Primești o cerere, verificăm marca, modelul, anul și tipul de geam, apoi revenim cu o ofertă. Dacă lipseau date importante, te întrebăm înainte să propunem o sticlă greșită.'],
                ['Ce contează la o lucrare corectă', 'Pregătirea canalului de lipire, poziționarea exactă, adezivul potrivit și timpul de așteptare. Preferăm să amânăm o intervenție decât să lipim într-un loc sau pe o vreme care compromite rezultatul.'],
                ['Transparență', 'Nu publicăm prețuri inventate, nu inventăm parteneriate cu asigurători și nu pretindem sedii în fiecare sector. Lucrăm în București (sectoarele 1–6); pentru Ilfov confirmăm disponibilitatea după localitate.'],
            ],
            'faq' => [
                ['Sunteți un marketplace?', 'Nu. Site-ul este al brandului Înlocuire Parbriz — cererea ajunge la echipa noastră.'],
                ['Unde lucrați?', 'În București, pe sectoarele 1–6. Pentru Ilfov, confirmăm pe baza adresei din cerere.'],
                ['Cum încep?', 'Din pagina Solicită ofertă: trimite detaliile mașinii și, dacă poți, o fotografie cu avaria.'],
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
            'inlocuire-parbriz-bucuresti' => 'Înlocuire Parbriz București | Montaj Profesional',
            'inlocuire-parbriz-la-domiciliu' => 'Înlocuire Parbriz la Domiciliu București | Montaj Mobil',
            'reparatie-parbriz' => 'Reparație Parbriz Ciobit București | Evaluare și Ofertă',
            'pret-inlocuire-parbriz' => 'Cât Costă Înlocuirea unui Parbriz? | Cere Ofertă',
            'calibrare-adas' => 'Calibrare ADAS după Schimbarea Parbrizului | București',
            'parbriz-pe-casco' => 'Înlocuire Parbriz prin CASCO | Pași și Documente',
            'parbrize-flote-firme' => 'Parbrize pentru Flote și Firme | Ofertă B2B',
            'inlocuire-luneta-si-geamuri-laterale' => 'Înlocuire Lunetă și Geamuri Laterale | București',
            'inlocuire-parbriz-ilfov' => 'Înlocuire Parbriz Ilfov | Disponibilitate pe Localitate',
        ];

        $meta = [
            'title' => $titleOverrides[$slug]
                ?? ($page['title'] ?? null)
                ?? (($page['h1'] ?? $page['name']).' | InlocuireParbriz.ro'),
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
                'title' => "Înlocuire parbriz Sectorul {$n} București | InlocuireParbriz.ro",
                'description' => "Înlocuire parbriz în Sectorul {$n}, București".($areasText ? " ({$areasText})" : '').'. Trimite detaliile mașinii și solicită ofertă.',
                'h1' => "Înlocuire parbriz în Sectorul {$n}",
            ],
        ]);
    }
}
