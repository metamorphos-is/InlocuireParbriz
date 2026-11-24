@extends('layouts.public')

@section('title', 'Înlocuire Parbriz București | Schimbare Parbriz la Domiciliu')
@section('description', 'Înlocuire parbriz în București — montaj profesional, inclusiv la domiciliu când condițiile permit. Trimite marca, modelul și anul mașinii pentru ofertă.')

@section('content')
@php
    $homeServices = [
        ['inlocuire-parbriz-bucuresti', 'Înlocuire parbriz', 'Schimbăm parbrizul după marca, modelul și dotările mașinii.', 'Vezi serviciul'],
        ['inlocuire-parbriz-la-domiciliu', 'La domiciliu', 'Montaj mobil când spațiul și vremea permit o lipire corectă.', 'Cum funcționează'],
        ['reparatie-parbriz', 'Reparație ciobitură', 'Evaluăm dacă se poate repara sau e nevoie de sticlă nouă.', 'Cere evaluare'],
        ['inlocuire-luneta-si-geamuri-laterale', 'Lunetă și geamuri', 'Lunetă, geam portieră sau geam fix — pe tipul corect de sticlă.', 'Detalii'],
        ['calibrare-adas', 'Calibrare ADAS', 'Îți explicăm când poate fi necesară după schimbarea parbrizului.', 'Află mai mult'],
        ['parbrize-flote-firme', 'Firme și flote', 'Cereri pentru mai multe mașini, cu programări coordonate.', 'Ofertă flotă'],
        ['parbriz-pe-casco', 'Parbriz pe CASCO', 'Ofertă și documente pentru dosar — fără parteneriate inventate.', 'Pași CASCO'],
        ['pret-inlocuire-parbriz', 'Prețuri', 'Ce influențează costul și cum obții o ofertă pe mașina ta.', 'Vezi factorii'],
    ];
    $faq = [
        ['Cât costă înlocuirea unui parbriz?', 'Depinde de mașină și de tipul de sticlă. Nu publicăm un preț unic — îți pregătim oferta după datele mașinii.'],
        ['Se poate schimba parbrizul la domiciliu?', 'Da, când spațiul, temperatura și vremea permit o lipire corectă. Dacă nu, propunem o alternativă.'],
        ['În cât timp se poate programa montajul?', 'Termenul se confirmă în ofertă, după ce verificăm sticla și disponibilitatea.'],
        ['Ce informații trebuie să trimit?', 'Marca, modelul, anul, tipul de geam și, dacă le ai, dotările vizibile sau o fotografie. VIN-ul ajută, dar nu e obligatoriu.'],
        ['Se poate repara o ciobitură?', 'Uneori, dacă e mică și recentă. Fisurile lungi cer, de regulă, înlocuire.'],
        ['Schimbați și lunete sau geamuri laterale?', 'Da. Precizează în formular ce geam este afectat.'],
        ['Ce se întâmplă dacă mașina are senzor de ploaie?', 'Identificăm sticla compatibilă cu senzorul și celelalte dotări.'],
        ['Este necesară calibrarea ADAS?', 'Depinde de model și de cerințele producătorului. Te informăm după analiza mașinii.'],
        ['Pot solicita schimbarea prin CASCO?', 'Poți folosi oferta noastră în relația cu asigurătorul. Acoperirea depinde de polița ta.'],
        ['Lucrați în toate sectoarele din București?', 'Da — Sectorul 1 până la Sectorul 6, în funcție de adresă și condițiile lucrării.'],
        ['Veniți și în Ilfov?', 'Confirmăm pe baza localității din cerere. Nu promitem acoperire automată pe tot județul.'],
        ['Ce se întâmplă după ce trimit formularul?', 'Analizăm datele, te contactăm la telefon și îți comunicăm oferta. Decizia de a continua îți aparține.'],
    ];
@endphp

{{-- HERO --}}
<section class="ee-hero">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-lg-8">
                <p class="ee-eyebrow mb-2">București · Ilfov pe confirmare</p>
                <h1 class="ee-hero__title">Înlocuire parbriz în București — <span>montaj profesional, inclusiv la domiciliu</span></h1>
                <p class="ee-hero__lead">Ai parbrizul crăpat sau spart? Trimite marca, modelul și anul mașinii. Verificăm ce sticlă se potrivește și îți pregătim o ofertă. În multe situații putem organiza montajul la domiciliu sau la birou.</p>
                <div class="ee-hero__actions">
                    <a href="{{ route('lead.create') }}" class="ee-btn ee-btn--amber ee-btn--lg">Solicită ofertă</a>
                    <a href="{{ route('lead.create') }}" class="ee-btn ee-btn--ghost ee-btn--lg">Trimite detaliile mașinii</a>
                </div>
                <ul class="ee-hero__points">
                    <li>@include('partials.icon', ['name' => 'check', 'size' => 18]) Ofertă pe baza datelor reale ale mașinii</li>
                    <li>@include('partials.icon', ['name' => 'check', 'size' => 18]) Montaj mobil când condițiile permit</li>
                    <li>@include('partials.icon', ['name' => 'check', 'size' => 18]) Fără angajament să accepți oferta</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- SERVICII --}}
<section class="ee-section">
    <div class="container">
        <div class="ee-section__head">
            <h2>Servicii de sticlă auto</h2>
            <p>Alege pagina potrivită intenției tale — fiecare serviciu are explicații, condiții și pași concreți.</p>
        </div>
        <div class="row g-4">
            @foreach ($homeServices as [$slug, $title, $text, $cta])
                <div class="col-md-6 col-lg-3">
                    <a class="ee-service-card" href="{{ url('/'.$slug) }}">
                        <h3>{{ $title }}</h3>
                        <p>{{ $text }}</p>
                        <span class="ee-service-card__cta">{{ $cta }} →</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CUM FUNCȚIONEAZĂ --}}
<section class="ee-section ee-section--alt">
    <div class="container">
        <div class="ee-section__head">
            <h2>Cum obții oferta și montajul</h2>
            <p>Proces clar, fără pași ascunși.</p>
        </div>
        @include('partials.process-steps', ['steps' => [
            ['Trimiți detaliile mașinii', 'Marcă, model, an, tip de geam și, dacă poți, o fotografie cu avaria.'],
            ['Verificăm tipul de geam', 'Luăm în calcul senzori, cameră, încălzire și compatibilitatea sticlei.'],
            ['Primești oferta', 'Te contactăm cu detaliile ofertei. Decizia de a continua îți aparține.'],
            ['Stabilim montajul', 'Alegem împreună locul: la tine, la birou sau într-un spațiu mai potrivit.'],
            ['Lucrarea și verificările', 'Montaj, indicații după lipire și verificările necesare pentru mașina ta.'],
        ]])
    </div>
</section>

{{-- DE CE --}}
<section class="ee-section">
    <div class="container">
        <div class="ee-section__head">
            <h2>Ce contează la o lucrare corectă</h2>
            <p>Avantaje reale, fără statistici inventate.</p>
        </div>
        <div class="row g-3">
            @foreach ([
                ['Identificare corectă', 'Parbrizul trebuie să se potrivească modelului și dotărilor — nu „aproape”.'],
                ['Condiții de montaj', 'Preferăm să amânăm decât să lipim pe vreme sau într-un spațiu nepotrivit.'],
                ['Ofertă înainte de programare', 'Știi ce ți se propune înainte să înceapă lucrarea.'],
                ['Explicații pe înțeles', 'Îți spunem ce presupune montajul și ce urmează după.'],
            ] as [$t, $d])
                <div class="col-md-6 col-lg-3">
                    <div class="ee-feature ee-feature--stack">
                        <span class="ee-feature__icon">@include('partials.icon', ['name' => 'check', 'size' => 22])</span>
                        <div><h3>{{ $t }}</h3><p>{{ $d }}</p></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- MOBIL --}}
<section class="ee-section ee-section--alt">
    <div class="container">
        <div class="row gy-4 align-items-start">
            <div class="col-lg-6">
                <h2>Schimbare parbriz la domiciliu</h2>
                <p class="text-muted-ee">Ne deplasăm la adresa din București când există spațiu, acces și condiții potrivite pentru adeziv. Ploaia puternică, gerul sau o parcare prea strâmtă pot cere un loc acoperit — ți-o spunem înainte.</p>
                <a href="{{ url('/inlocuire-parbriz-la-domiciliu') }}" class="ee-btn ee-btn--outline mt-2">Solicită montaj la domiciliu</a>
            </div>
            <div class="col-lg-6">
                <ul class="ee-checklist">
                    <li>Loc plan, cu spațiu pentru deschiderea portierelor</li>
                    <li>Preferabil acoperit pe vreme rea</li>
                    <li>Acces clar în ansambluri cu bariere</li>
                    <li>Programare după confirmarea sticlei</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- TEHNIC --}}
<section class="ee-section">
    <div class="container">
        <div class="ee-section__head">
            <h2>Dotări care schimbă tipul de parbriz</h2>
            <p>Două sticle care par identice pot diferi la senzori sau cameră.</p>
        </div>
        <div class="row g-3">
            @foreach ([
                ['Senzor de ploaie', 'Poziția și tipul senzorului influențează sticla potrivită.'],
                ['Cameră ADAS', 'După montaj, unele modele pot necesita calibrare.'],
                ['Încălzire', 'Parbrizul sau luneta pot avea rezistențe electrice.'],
                ['HUD / acustic', 'Proiecție pe sticlă sau strat de izolare fonică.'],
            ] as [$t, $d])
                <div class="col-sm-6 col-lg-3">
                    <div class="ee-tech">
                        <h3>{{ $t }}</h3>
                        <p>{{ $d }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- REPARAȚIE VS ÎNLOCUIRE --}}
<section class="ee-section ee-section--alt">
    <div class="container">
        <div class="ee-section__head">
            <h2>Reparație sau înlocuire?</h2>
            <p>Nu orice impact înseamnă automat un parbriz nou — dar nici orice fisură nu se poate repara.</p>
        </div>
        @include('partials.compare-blocks', [
            'leftTitle' => 'Poate fi reparație',
            'rightTitle' => 'De regulă înlocuire',
            'leftItems' => [
                'Ciobitură mică, recentă',
                'Departe de marginea sticlei',
                'În afara câmpului principal de vizibilitate',
                'Evaluare pe fotografie + confirmare la fața locului',
            ],
            'rightItems' => [
                'Fisuri lungi sau care se extind',
                'Impacturi multiple',
                'Aproape de margine sau de senzori',
                'Sticlă cu straturi afectate',
            ],
        ])
        <p class="mt-4 mb-0"><a class="ee-link" href="{{ url('/reparatie-parbriz') }}">Cere evaluarea deteriorării →</a></p>
    </div>
</section>

{{-- ZONE --}}
<section class="ee-section">
    <div class="container">
        <div class="ee-section__head">
            <h2>Zone deservite</h2>
            <p>București pe toate sectoarele; Ilfov pe confirmare după localitate.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <a class="ee-service-card" href="{{ url('/inlocuire-parbriz-bucuresti') }}">
                    <h3>București</h3>
                    <p>Sectorul 1–6. Vezi pagina București și paginile pe sector pentru detalii locale.</p>
                    <span class="ee-service-card__cta">Vezi acoperirea →</span>
                </a>
            </div>
            <div class="col-md-6">
                <a class="ee-service-card" href="{{ url('/inlocuire-parbriz-ilfov') }}">
                    <h3>Ilfov</h3>
                    <p>Disponibilitatea se confirmă în ofertă, pe baza localității din cerere.</p>
                    <span class="ee-service-card__cta">Verifică localitatea →</span>
                </a>
            </div>
        </div>
        <div class="ee-sector-row mt-4">
            @foreach (range(1, 6) as $n)
                <a href="{{ url('/inlocuire-parbriz-bucuresti/sector-'.$n) }}">Sectorul {{ $n }}</a>
            @endforeach
        </div>
    </div>
</section>

{{-- FLOTE --}}
<section class="ee-section ee-section--alt">
    <div class="container">
        <div class="row gy-3 align-items-center">
            <div class="col-lg-8">
                <h2>Parbrize pentru firme și flote</h2>
                <p class="mb-0">Cerere pentru mai multe vehicule, identificare pe fiecare mașină, programări la sediu când locația permite.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ url('/parbrize-flote-firme') }}" class="ee-btn ee-btn--amber">Solicită ofertă pentru flotă</a>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="ee-section" id="intrebari">
    <div class="container ee-narrow">
        <div class="ee-section__head">
            <h2>Întrebări frecvente</h2>
        </div>
        <div class="ee-faq">
            @foreach ($faq as [$q, $a])
                <details class="ee-faq__item">
                    <summary>{{ $q }}</summary>
                    <p>{{ $a }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

@include('partials.cta-banner', [
    'ctaTitle' => 'Ai nevoie de un parbriz nou?',
    'ctaText' => 'Trimite marca, modelul și anul mașinii. Dacă poți, menționează și o fotografie cu avaria.',
    'ctaLabel' => 'Solicită ofertă',
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
