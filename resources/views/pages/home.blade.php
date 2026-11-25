@extends('layouts.public')

@section('title', 'Înlocuire parbriz în toată țara – schimbare și montaj | inlocuireparbriz.ro')
@section('description', 'Înlocuire, schimbare și montaj parbriz prin ateliere partenere verificate din orașul tău. Trimite marca, modelul și anul mașinii și primești oferta pe sticla potrivită.')

@section('content')
@php
    $services = [
        ['windshield', 'Înlocuire parbriz', 'Parbriz nou, pe varianta exactă de dotări a mașinii', route('lead.create')],
        ['chip', 'Reparație parbriz', 'Ciobiturile mici și recente se pot repara, fără parbriz nou', url('/reparatie-parbriz')],
        ['home', 'Montaj la domiciliu', 'La adresa ta, când locul și vremea permit o lipire corectă', url('/inlocuire-parbriz-la-domiciliu')],
        ['rear', 'Lunetă și geamuri laterale', 'Geam spate, geam de portieră sau geam fix', url('/inlocuire-luneta-si-geamuri-laterale')],
        ['camera', 'Calibrare ADAS', 'Camera și senzorii de pe parbriz, după schimbare', url('/calibrare-adas')],
        ['doc', 'Parbriz prin CASCO', 'Ofertă și documente pentru dosarul de daună', url('/parbriz-pe-casco')],
        ['truck', 'Firme și flote', 'Cereri pentru mai multe vehicule deodată', url('/parbrize-flote-firme')],
        ['tag', 'Preț parbriz', 'Ce influențează costul și cum primești oferta', url('/pret-inlocuire-parbriz')],
    ];
    $faq = [
        ['Cât costă înlocuirea unui parbriz?', 'Prețul depinde de model, de an și de dotările sticlei (senzor de ploaie, cameră, încălzire, HUD). Nu publicăm un preț unic pentru că ar fi inexact — primești oferta pe mașina ta, înainte de orice programare.'],
        ['Cine face montajul?', 'Un atelier partener verificat din orașul tău. Noi preluăm cererea, verificăm ce sticlă se potrivește și o transmitem atelierului, care îți face oferta și lucrarea.'],
        ['În ce orașe se poate face montajul?', 'Avem pagini dedicate pentru orașele mari, dar poți trimite cererea din orice localitate. Dacă nu avem încă un atelier partener confirmat în zona ta, îți spunem asta înainte de orice angajament.'],
        ['Se poate schimba parbrizul la domiciliu?', 'Da, când există un loc plan, ferit de ploaie și o temperatură potrivită pentru adeziv. Dacă nu, montajul se face în atelier.'],
        ['Ce informații trebuie să trimit?', 'Marca, modelul, anul de fabricație și tipul geamului. Seria de șasiu (VIN) și o fotografie cu avaria ajută, dar nu sunt obligatorii.'],
        ['Se poate repara o ciobitură în loc de înlocuire?', 'Uneori — dacă impactul e mic, recent și departe de marginea sticlei. Fisurile lungi cer, de regulă, parbriz nou.'],
        ['Pot plăti prin CASCO?', 'Poți folosi oferta în relația cu asigurătorul. Ce se decontează depinde de polița ta, așa că verifică întâi condițiile cu asigurătorul.'],
        ['Sunt obligat să accept oferta?', 'Nu. Primești oferta, iar decizia de a continua îți aparține.'],
    ];
@endphp

{{-- HERO --}}
<section class="ip-hero ip-hero--home">
    <div class="container">
        <div class="ip-hero__grid">
            <div>
                <p class="ip-kicker">@include('partials.icon', ['name' => 'map', 'size' => 16]) Cereri din toată țara</p>
                <h1 class="ip-hero__title">Înlocuire parbriz în orașul tău, <span class="ip-accent">pe sticla potrivită mașinii</span></h1>
                <p class="ip-hero__lead">Parbriz spart, fisurat sau ciobit? Trimite marca, modelul și anul mașinii. Primești oferta și montajul prin atelierele partenere verificate din orașul tău — la atelier sau la adresa ta, când condițiile permit.</p>
                <div class="ip-hero__actions">
                    <a href="{{ route('lead.create') }}" class="ip-btn ip-btn--cta ip-btn--lg" data-track="cta_home_hero">Cere ofertă gratuită</a>
                    <a href="#cum-functioneaza" class="ip-btn ip-btn--ghost ip-btn--lg">Cum funcționează</a>
                </div>
                <ul class="ip-hero__points">
                    <li>@include('partials.icon', ['name' => 'check', 'size' => 18]) Ofertă înainte de programare</li>
                    <li>@include('partials.icon', ['name' => 'check', 'size' => 18]) Sticlă potrivită dotărilor</li>
                    <li>@include('partials.icon', ['name' => 'check', 'size' => 18]) Fără obligația de a accepta</li>
                </ul>
            </div>

            <aside class="ip-finder" aria-labelledby="ip-finder-title">
                <p class="ip-finder__title" id="ip-finder-title">@include('partials.icon', ['name' => 'pin', 'size' => 20]) Unde ai nevoie de parbriz?</p>
                <form action="{{ route('lead.create') }}" method="get" class="ip-finder__form" data-ip-city-finder>
                    <label class="visually-hidden" for="ip-finder-city">Orașul</label>
                    <select id="ip-finder-city" name="oras" class="form-select">
                        <option value="">Alege orașul…</option>
                        @foreach ($regions as $region)
                            <optgroup label="{{ $region['label'] }}">
                                @foreach ($region['items'] as $c)
                                    <option value="{{ $c['name'] }}" data-url="{{ url('/inlocuire-parbriz-'.$c['slug']) }}">{{ $c['name'] }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                        <option value="" data-url="{{ route('lead.create', ['zona' => 'alt_oras']) }}">Alt oraș / localitate</option>
                    </select>
                    <input type="hidden" name="zona" value="alt_oras">
                    <button type="submit" class="ip-btn ip-btn--cta w-100">Continuă</button>
                </form>
                <p class="ip-finder__note">Pagini dedicate pentru {{ $cityCount }}+ orașe. Din alte localități trimiți cererea direct și îți confirmăm disponibilitatea în zona ta.</p>
            </aside>
        </div>
    </div>
</section>

{{-- SERVICII --}}
<section class="ee-section">
    <div class="container">
        <div class="ip-section-head">
            <h2 class="ip-section-title">Servicii pentru parbrize și geamuri auto</h2>
            <p>Schimbare parbriz, reparație, lunetă sau geam lateral — alege ce ți s-a întâmplat.</p>
        </div>
        <div class="ip-service-grid ip-service-grid--4">
            @foreach ($services as [$icon, $title, $text, $href])
                <a class="ip-service-card" href="{{ $href }}">
                    <span class="ip-mlink__icon">@include('partials.icon', ['name' => $icon, 'size' => 22])</span>
                    <span class="ip-service-card__title">{{ $title }}</span>
                    <span class="ip-service-card__text">{{ $text }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- CUM FUNCȚIONEAZĂ --}}
<section class="ee-section ee-section--alt" id="cum-functioneaza">
    <div class="container">
        <div class="ip-section-head">
            <h2 class="ip-section-title">Cum funcționează</h2>
            <p>Patru pași, fără costuri ascunse și fără angajament până nu accepți oferta.</p>
        </div>
        @include('partials.process-steps', ['steps' => [
            ['Trimiți detaliile mașinii', 'Marcă, model, an, geamul afectat și orașul. Dacă poți, adaugă seria de șasiu și o fotografie.'],
            ['Verificăm sticla potrivită', 'Ținem cont de senzor de ploaie, cameră, încălzire sau HUD — două parbrize care par identice pot fi diferite.'],
            ['Primești oferta', 'Atelierul partener din orașul tău îți trimite prețul, termenul și locul montajului.'],
            ['Montajul', 'La atelier sau la adresa ta, apoi indicațiile pentru timpul de uscare a adezivului.'],
        ], 'wide' => true])
    </div>
</section>

{{-- ORAȘE --}}
<section class="ee-section" id="orase">
    <div class="container">
        <div class="ip-section-head">
            <h2 class="ip-section-title">Parbrize în orașul tău</h2>
            <p>Fiecare oraș are o pagină cu detalii locale. Dacă orașul tău nu e în listă, <a href="{{ route('lead.create', ['zona' => 'alt_oras']) }}">trimite cererea</a> și îți confirmăm disponibilitatea în zona ta.</p>
        </div>
        <div class="ip-regions">
            @foreach ($regions as $region)
                <div class="ip-region">
                    <h3 class="ip-region__title">{{ $region['label'] }}</h3>
                    <ul class="ip-region__list">
                        @foreach ($region['items'] as $c)
                            <li><a href="{{ url('/inlocuire-parbriz-'.$c['slug']) }}">Parbrize {{ $c['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PARBRIZ PE MODEL --}}
@php
    try {
        $homeModels = \Illuminate\Support\Facades\Cache::remember('home:vehicles:v1', 600, fn () => \App\Models\VehiclePage::query()->models()->published()
            ->orderByDesc('search_volume')->limit(12)->get(['brand_name', 'brand_slug', 'model_name', 'model_slug'])
            ->map(fn ($m) => ['label' => $m->brand_name.' '.$m->model_name, 'url' => $m->path()])->all());
    } catch (\Throwable) {
        $homeModels = [];
    }
@endphp
@if ($homeModels)
<section class="ee-section" id="modele">
    <div class="container">
        <div class="ip-section-head">
            <h2 class="ip-section-title">Parbriz pe marcă și model</h2>
            <p>Vezi ce variante de parbriz există pentru mașina ta — cu senzor de ploaie, încălzire sau cameră — și ce trebuie verificat înainte de comandă. <a href="{{ route('vehicles.index') }}">Toate mărcile și modelele</a>.</p>
        </div>
        <ul class="ip-city-links">
            @foreach ($homeModels as $m)
                <li><a href="{{ url($m['url']) }}">@include('partials.icon', ['name' => 'windshield', 'size' => 16]) Parbriz {{ $m['label'] }}</a></li>
            @endforeach
        </ul>
    </div>
</section>
@endif

{{-- REPARAȚIE VS ÎNLOCUIRE --}}
<section class="ee-section ee-section--alt">
    <div class="container">
        <div class="row g-4 g-lg-5 align-items-center">
            <div class="col-lg-5">
                @include('partials.photo', ['slug' => 'ciobitura-parbriz-impact-piatra', 'class' => 'ip-photo--hero', 'sizes' => '(min-width: 992px) 480px, 100vw'])
            </div>
            <div class="col-lg-7">
                <div class="ip-section-head">
                    <h2 class="ip-section-title">Reparație sau schimbare parbriz?</h2>
                    <p>Nu orice impact înseamnă un parbriz nou — dar nici orice fisură nu se poate repara. O ciobitură mică, prinsă în primele zile, poate fi umplută cu rășină; o fisură lungă sau una care pornește de la margine cere, de regulă, sticlă nouă.</p>
                </div>
                @include('partials.compare-blocks', [
                    'leftTitle' => 'Se poate repara, de obicei',
                    'rightTitle' => 'Trebuie înlocuit, de regulă',
                    'leftItems' => [
                        'Ciobitură mică și recentă',
                        'Departe de marginea sticlei',
                        'În afara câmpului de vedere al șoferului',
                    ],
                    'rightItems' => [
                        'Fisură lungă sau care se extinde',
                        'Impact aproape de margine sau de senzori',
                        'Mai multe impacturi pe aceeași sticlă',
                    ],
                ])
                <p class="mt-4 mb-0"><a class="ee-link" href="{{ url('/reparatie-parbriz') }}">Află când se poate repara un parbriz →</a></p>
            </div>
        </div>
    </div>
</section>

{{-- DOTĂRI --}}
<section class="ee-section">
    <div class="container">
        <div class="ip-section-head">
            <h2 class="ip-section-title">De ce contează dotările la montajul parbrizului</h2>
            <p>Același model de mașină poate avea mai multe variante de parbriz. De aceea cerem datele mașinii înainte de ofertă.</p>
        </div>
        <div class="row g-4 align-items-stretch mb-4">
            <div class="col-md-6">@include('partials.photo', ['slug' => 'parbriz-ploaie-senzor', 'class' => 'ip-photo--card', 'sizes' => '(min-width: 768px) 50vw, 100vw'])</div>
            <div class="col-md-6">@include('partials.photo', ['slug' => 'montaj-parbriz-nou-doi-tehnicieni', 'class' => 'ip-photo--card', 'sizes' => '(min-width: 768px) 50vw, 100vw'])</div>
        </div>
        <div class="ip-service-grid ip-service-grid--4">
            @foreach ([
                ['sensor', 'Senzor de ploaie și lumină', 'Schimbă suportul lipit pe sticlă și tipul de parbriz.'],
                ['camera', 'Cameră și ADAS', 'Asistența la menținerea benzii poate cere calibrare după montaj.'],
                ['flame', 'Parbriz încălzit', 'Rezistențele din sticlă trebuie să existe și pe parbrizul nou.'],
                ['panel', 'HUD și strat acustic', 'Proiecția pe parbriz și izolarea fonică cer sticlă specială.'],
            ] as [$icon, $t, $d])
                <div class="ip-service-card ip-service-card--static">
                    <span class="ip-mlink__icon">@include('partials.icon', ['name' => $icon, 'size' => 22])</span>
                    <span class="ip-service-card__title">{{ $t }}</span>
                    <span class="ip-service-card__text">{{ $d }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="ee-section ee-section--alt" id="intrebari">
    <div class="container ee-narrow">
        <div class="ee-section__head"><h2>Întrebări frecvente</h2></div>
        <div class="ee-faq">
            @foreach ($faq as [$q, $a])
                <details class="ee-faq__item">
                    <summary>{{ $q }}</summary>
                    <p>{{ $a }}</p>
                </details>
            @endforeach
        </div>
        <p class="mt-3"><a href="{{ route('faq') }}">Toate întrebările frecvente despre parbriz</a></p>
    </div>
</section>

@include('partials.cta-banner', [
    'ctaTitle' => 'Ai nevoie de un parbriz nou?',
    'ctaText' => 'Trimite marca, modelul și anul mașinii — primești oferta pe sticla potrivită, de la un atelier partener din orașul tău.',
    'ctaLabel' => 'Cere ofertă',
])
@endsection

@push('head')
@php
    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn ($i) => [
            '@type' => 'Question',
            'name' => $i[0],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $i[1]],
        ], $faq),
    ];
@endphp
<script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
