@extends('layouts.public')

@php
    $name = $page->fullName();
    $short = $page->model_name;
    $img = \App\Support\Img::exists($page->image) ? $page->image : 'montaj-parbriz-nou-autoturism-alb';
    $leadUrl = route('lead.create', ['serviciu' => 'inlocuire-parbriz-bucuresti', 'marca' => $page->brand_name, 'model' => $page->model_name]);
    $adasText = [
        'common' => "Multe exemplare {$short} au cameră pe parbriz (în spatele oglinzii retrovizoare), folosită de asistența la menținerea benzii, recunoașterea indicatoarelor sau frânarea automată. După montajul unui parbriz nou, camera trebuie de regulă recalibrată, iar asta se stabilește în ofertă.",
        'optional' => "Doar unele versiuni {$short} au cameră pe parbriz. Dacă în spatele oglinzii vezi o carcasă mare cu un obiectiv îndreptat spre drum, spune-ne în cerere: parbrizul are atunci un suport special, iar după montaj camera poate avea nevoie de calibrare.",
        'none' => "În general, {$short} nu are cameră de asistență pe parbriz, deci nu e nevoie de calibrare după montaj. Dacă mașina ta are totuși un echipament montat ulterior în spatele oglinzii (cameră de bord, tag de taxare), spune-ne, ca să fie demontat și remontat corect.",
    ][$page->adas ?? 'none'] ?? null;
    $faq = array_merge(array_map(fn ($f) => [$f['q'] ?? '', $f['a'] ?? ''], (array) $page->faq), [
        ["Cât costă un parbriz pentru {$name}?", "Prețul depinde de varianta exactă de parbriz (simplu, cu senzor, încălzit, cu cameră), de producător (original sau echivalent) și de locul montajului. Nu publicăm tarife generice: trimite marca, modelul, anul și, ideal, seria de șasiu, iar oferta vine pe varianta corectă pentru mașina ta."],
        ['Cât durează înlocuirea?', 'Montajul propriu-zis durează de obicei 1–2 ore. După lipire, adezivul are nevoie de timp de întărire înainte să conduci; îți spunem exact cât odată cu oferta, în funcție de adeziv și de temperatură.'],
    ]);
    $years = $page->years ? " ({$page->years})" : '';
@endphp

@section('title', $page->seo_title ?: "Parbriz {$name} – variante, preț și montaj | inlocuireparbriz.ro")
@section('description', $page->meta_description ?: $page->intro)
@section('og_image', $img)

@section('content')
<section class="ip-hero">
    <div class="container">
        <nav class="ip-crumbs" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Acasă</a><span aria-hidden="true">›</span>
            <a href="{{ route('vehicles.index') }}">Parbriz pe model</a><span aria-hidden="true">›</span>
            <a href="{{ url('/parbriz-auto/'.$page->brand_slug) }}">{{ $page->brand_name }}</a><span aria-hidden="true">›</span>
            <span aria-current="page">{{ $short }}</span>
        </nav>
        <div class="ip-hero__grid">
            <div>
                <p class="ip-kicker">@include('partials.icon', ['name' => 'windshield', 'size' => 16]) {{ $name }}{{ $years }}</p>
                <h1 class="ip-hero__title">{{ $page->h1 ?: "Parbriz {$name}: variante, preț și înlocuire" }}</h1>
                <p class="ip-hero__lead">{{ $page->intro }}</p>
                <div class="ip-hero__actions">
                    <a href="{{ $leadUrl }}" class="ip-btn ip-btn--cta ip-btn--lg" data-track="cta_vehicle">Cere ofertă pentru {{ $short }}</a>
                    <a href="#variante" class="ip-btn ip-btn--ghost ip-btn--lg">Ce variante există</a>
                </div>
            </div>
            @include('partials.photo', ['slug' => $img, 'eager' => true, 'class' => 'ip-photo--hero', 'alt' => \App\Support\Img::get($img)['alt'].' – parbriz '.$name])
        </div>
    </div>
</section>

<section class="ee-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="ee-prose ip-prose">
                    @if ($page->years || $page->bodies)
                        <h2>Despre {{ $name }}</h2>
                        <ul>
                            @if ($page->years)<li><strong>Ani de fabricație:</strong> {{ $page->years }}</li>@endif
                            @if ($page->bodies)<li><strong>Caroserii:</strong> {{ $page->bodies }}</li>@endif
                            <li><strong>Cameră pe parbriz:</strong> {{ mb_strtolower(\App\Models\VehiclePage::ADAS[$page->adas ?? 'none'] ?? '') }}</li>
                        </ul>
                    @endif

                    <h2 id="variante">Ce variante de parbriz există pentru {{ $short }}</h2>
                    <p>Pentru același model se fabrică mai multe parbrize, care arată la fel de la distanță, dar diferă prin suporturi, rezistențe sau straturi speciale. Varianta greșită nu se potrivește dotărilor mașinii, așa că o identificăm înainte de ofertă:</p>
                    <ul>
                        @foreach ((array) $page->variants as $v)
                            <li>{{ $v }}</li>
                        @endforeach
                    </ul>

                    @foreach ((array) $page->sections as $s)
                        <h2>{{ $s['heading'] ?? '' }}</h2>
                        <p>{{ $s['body'] ?? '' }}</p>
                    @endforeach

                    <h2>Cum afli ce parbriz are mașina ta</h2>
                    <p>Cel mai sigur reper este seria de șasiu (VIN), din talonul mașinii: cu ea se verifică echiparea din fabrică. Te ajută și o fotografie cu zona din spatele oglinzii retrovizoare (senzori, cameră) și una cu eticheta din colțul parbrizului actual, unde apar producătorul și codurile sticlei. Nu e obligatoriu să ai toate datele de la început — te întrebăm noi ce lipsește.</p>

                    @if ($adasText)
                        <h2>Calibrarea camerei după montaj</h2>
                        <p>{{ $adasText }} Detalii pe pagina <a href="{{ url('/calibrare-adas') }}">calibrare ADAS</a>.</p>
                    @endif

                    <h2>De ce diferă prețul parbrizului pentru {{ $short }}</h2>
                    <p>Diferențele mari de preț între două oferte pentru {{ $name }} vin aproape mereu din varianta de sticlă: un parbriz simplu costă mai puțin decât unul cu senzor de ploaie, iar unul încălzit sau cu suport de cameră costă mai mult. Contează și dacă alegi sticlă originală sau un echivalent de calitate (vezi <a href="{{ url('/blog/parbriz-original-oem-aftermarket') }}">parbriz original sau aftermarket</a>) și dacă montajul se face la atelier sau <a href="{{ url('/inlocuire-parbriz-la-domiciliu') }}">la domiciliu</a>. Mai multe despre factorii de preț găsești pe pagina <a href="{{ url('/pret-inlocuire-parbriz') }}">preț înlocuire parbriz</a>.</p>

                    <h2>Doar o ciobitură?</h2>
                    <p>Dacă parbrizul are un impact mic, recent și departe de margine, s-ar putea să nu fie nevoie de parbriz nou. Trimite o fotografie și îți spunem dacă se poate face o <a href="{{ url('/reparatie-parbriz') }}">reparație de parbriz</a>.</p>
                </div>

                <div class="mt-5" id="intrebari">
                    <h2 class="h3 mb-3">Întrebări frecvente — parbriz {{ $name }}</h2>
                    <div class="ee-faq">
                        @foreach ($faq as [$q, $a])
                            <details class="ee-faq__item">
                                <summary>{{ $q }}</summary>
                                <p>{{ $a }}</p>
                            </details>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <aside class="ee-panel ee-panel--sticky">
                    <h2 class="ee-panel__title">Ofertă pentru {{ $name }}</h2>
                    <p class="ee-panel__text">Trimite anul și, dacă îl ai, seria de șasiu. Primești oferta pe varianta corectă de parbriz, prin atelierele partenere verificate din orașul tău.</p>
                    <a href="{{ $leadUrl }}" class="ip-btn ip-btn--cta w-100" data-track="cta_vehicle_aside">Cere ofertă</a>
                    @if ($siblings->isNotEmpty())
                        <hr>
                        <p class="ip-toc__title">Alte modele {{ $page->brand_name }}</p>
                        <ul class="ip-toc">
                            @foreach ($siblings as $s)
                                <li><a href="{{ $s->url() }}">Parbriz {{ $s->model_name }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </aside>
            </div>
        </div>
    </div>
</section>

@if ($cities->isNotEmpty())
<section class="ee-section ee-section--alt">
    <div class="container">
        <h2 class="ip-section-title">Înlocuire parbriz {{ $short }} în orașul tău</h2>
        <ul class="ip-city-links">
            <li><a href="{{ url('/inlocuire-parbriz-bucuresti') }}">@include('partials.icon', ['name' => 'pin', 'size' => 16]) Parbrize București</a></li>
            @foreach ($cities as $c)
                <li><a href="{{ $c->url() }}">@include('partials.icon', ['name' => 'pin', 'size' => 16]) Parbrize {{ $c->name }}</a></li>
            @endforeach
        </ul>
    </div>
</section>
@endif

@include('partials.cta-banner', [
    'ctaTitle' => "Parbriz spart sau fisurat la {$name}?",
    'ctaText' => 'Trimite anul și seria de șasiu — identificăm varianta corectă și revenim cu oferta.',
    'ctaHref' => $leadUrl,
    'ctaLabel' => 'Cere ofertă',
])

@push('head')
@php
    $graph = [
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Acasă', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Parbriz pe model', 'item' => route('vehicles.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $page->brand_name, 'item' => url('/parbriz-auto/'.$page->brand_slug)],
                ['@type' => 'ListItem', 'position' => 4, 'name' => $short, 'item' => $page->url()],
            ],
        ],
        [
            '@type' => 'Service',
            'name' => 'Înlocuire parbriz '.$name,
            'serviceType' => 'Înlocuire parbriz',
            'description' => $page->meta_description ?: $page->intro,
            'provider' => ['@id' => rtrim(config('inlocuireparbriz.canonical_url'), '/').'/#organization'],
            'areaServed' => ['@type' => 'Country', 'name' => 'România'],
            'url' => $page->url(),
        ],
        [
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($f) => ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]], $faq),
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
@endsection
