@extends('layouts.public')

@section('title', $city->seo_title ?: "Înlocuire parbriz {$city->name} | inlocuireparbriz.ro")
@section('description', $city->meta_description ?: $city->intro)
@php
    [$heroImg, $secondImg] = \App\Support\Img::forCity($city, (int) $city->sort_order);
@endphp
@section('og_image', $heroImg)

@section('content')
@php
    $active = $city->hasActiveCoverage();
    $leadUrl = route('lead.create', ['zona' => 'alt_oras', 'oras' => $city->name]);
    $services = [
        ['windshield', 'Înlocuire parbriz', 'Parbriz nou, pe varianta exactă de dotări', route('lead.create', ['zona' => 'alt_oras', 'oras' => $city->name, 'serviciu' => 'inlocuire-parbriz-bucuresti'])],
        ['chip', 'Reparație ciobitură', 'Evaluăm dacă impactul se poate repara', url('/reparatie-parbriz')],
        ['home', 'Montaj la adresă', 'Când locul și vremea permit o lipire corectă', url('/inlocuire-parbriz-la-domiciliu')],
        ['rear', 'Lunetă și geamuri laterale', 'Geam spate, portieră sau geam fix', url('/inlocuire-luneta-si-geamuri-laterale')],
        ['camera', 'Calibrare ADAS', 'Camera și senzorii după schimbare', url('/calibrare-adas')],
        ['tag', 'Prețuri', 'Ce influențează costul unui parbriz', url('/pret-inlocuire-parbriz')],
    ];
    $genericFaq = [
        ['Ce informații trebuie să trimit?', 'Marca, modelul, anul de fabricație și, ideal, seria de șasiu (VIN). Spune-ne și dacă ai senzor de ploaie, cameră pe parbriz sau parbriz încălzit — acestea schimbă varianta de sticlă și prețul.'],
        ['Cine face montajul?', 'Un atelier partener verificat din zona ta. Noi preluăm cererea, verificăm sticla potrivită și o transmitem atelierului, care îți face oferta și lucrarea.'],
    ];
    $faq = array_merge(array_map(fn ($f) => [$f['q'], $f['a']], (array) $city->faq), $genericFaq);
@endphp

<section class="ip-hero">
    <div class="container">
        <nav class="ip-crumbs" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Acasă</a>
            <span aria-hidden="true">›</span>
            <span>Locații</span>
            <span aria-hidden="true">›</span>
            <span aria-current="page">{{ $city->name }}</span>
        </nav>
        <div class="ip-hero__grid">
            <div>
                <p class="ip-kicker">@include('partials.icon', ['name' => 'pin', 'size' => 16]) {{ $city->name }}@if ($city->county && $city->county !== $city->name), județul {{ $city->county }}@endif</p>
                <h1 class="ip-hero__title">{{ $city->h1 ?: "Înlocuire parbriz în {$city->name}" }}</h1>
                <p class="ip-hero__lead">{{ $city->intro }}</p>
                <div class="ip-hero__actions">
                    <a href="{{ $leadUrl }}" class="ip-btn ip-btn--cta ip-btn--lg" data-track="cta_city">Cere ofertă pentru {{ $city->name }}</a>
                    <a href="#cum-functioneaza" class="ip-btn ip-btn--ghost ip-btn--lg">Cum funcționează</a>
                </div>
                <p class="ip-coverage-note {{ $active ? 'is-active' : '' }}">
                    @include('partials.icon', ['name' => $active ? 'check' : 'info', 'size' => 18])
                    @if ($active)
                        Ateliere partenere active în {{ $city->name }}: primești oferta și montajul în zona ta.
                    @else
                        Disponibilitate confirmată la cerere: îți spunem dacă un atelier partener din {{ $city->name }} preia lucrarea, înainte de orice angajament.
                    @endif
                </p>
            </div>
            @include('partials.photo', [
                'slug' => $heroImg,
                'eager' => true,
                'class' => 'ip-photo--hero',
                'alt' => \App\Support\Img::get($heroImg)['alt'].' – înlocuire parbriz '.$city->name,
            ])
        </div>
    </div>
</section>

<section class="ee-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="ee-prose ip-prose">
                    @foreach ((array) $city->sections as $i => $section)
                        <h2>{{ $section['heading'] ?? '' }}</h2>
                        <p>{{ $section['body'] ?? '' }}</p>
                        @if ($i === 0)
                            @include('partials.photo', ['slug' => $secondImg, 'class' => 'ip-photo--inline', 'sizes' => '(min-width: 992px) 760px, 100vw', 'caption' => \App\Support\Img::get($secondImg)['alt']])
                        @endif
                    @endforeach

                    @if (! empty($city->areas))
                        <h2>Zone din {{ $city->name }} și împrejurimi</h2>
                        <p>Poți trimite cererea din orice cartier sau localitate din apropiere. Scrie adresa exactă în formular — de ea depinde unde se poate face montajul.</p>
                        <ul class="ip-chips">
                            @foreach ($city->areas as $area)
                                <li>{{ $area }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="mt-5" id="cum-functioneaza">
                    <h2 class="h3 mb-3">Cum funcționează în {{ $city->name }}</h2>
                    @include('partials.process-steps', ['steps' => [
                        ['Trimiți detaliile mașinii', 'Marcă, model, an, tipul geamului și, dacă poți, seria de șasiu și o fotografie cu avaria.'],
                        ['Verificăm sticla potrivită', 'Ținem cont de senzori, cameră, încălzire și de varianta exactă montată din fabrică.'],
                        [$active ? 'Primești oferta' : 'Confirmăm disponibilitatea', $active ? 'Atelierul partener din zonă îți trimite oferta, cu prețul și locul montajului.' : 'Îți spunem dacă un atelier partener din zona ta poate prelua lucrarea și îți trimitem oferta.'],
                        ['Montajul', 'La atelier sau la adresa ta, când spațiul și vremea permit o lipire corectă.'],
                    ]])
                </div>
            </div>
            <div class="col-lg-4">
                <aside class="ee-panel ee-panel--sticky">
                    <h2 class="ee-panel__title">Ofertă pentru {{ $city->name }}</h2>
                    <p class="ee-panel__text">Trimite marca, modelul și anul mașinii. Răspundem cu varianta corectă de parbriz și disponibilitatea în zona ta.</p>
                    <a href="{{ $leadUrl }}" class="ip-btn ip-btn--cta w-100" data-track="cta_city_aside">Cere ofertă</a>
                    <ul class="ip-checklist mt-3">
                        <li>@include('partials.icon', ['name' => 'check', 'size' => 16]) Ofertă înainte de programare</li>
                        <li>@include('partials.icon', ['name' => 'check', 'size' => 16]) Fără obligația de a accepta</li>
                        <li>@include('partials.icon', ['name' => 'check', 'size' => 16]) Sticlă potrivită dotărilor</li>
                    </ul>
                </aside>
            </div>
        </div>
    </div>
</section>

<section class="ee-section ee-section--alt">
    <div class="container">
        <h2 class="ip-section-title">Servicii disponibile pe cerere în {{ $city->name }}</h2>
        <div class="ip-service-grid">
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

<section class="ee-section" id="intrebari">
    <div class="container ee-narrow">
        <div class="ee-section__head"><h2>Întrebări frecvente — {{ $city->name }}</h2></div>
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

@if ($nearby->isNotEmpty())
<section class="ee-section ee-section--alt">
    <div class="container">
        <h2 class="ip-section-title">Alte orașe din {{ \App\Models\City::REGIONS[$city->region] ?? 'zonă' }}</h2>
        <ul class="ip-city-links">
            @foreach ($nearby as $n)
                <li><a href="{{ $n->url() }}">@include('partials.icon', ['name' => 'pin', 'size' => 16]) Parbrize {{ $n->name }}</a></li>
            @endforeach
        </ul>
    </div>
</section>
@endif

@include('partials.cta-banner', [
    'ctaTitle' => "Parbriz spart sau fisurat în {$city->name}?",
    'ctaText' => 'Trimite datele mașinii — îți confirmăm sticla potrivită și disponibilitatea în zona ta.',
    'ctaHref' => $leadUrl,
    'ctaLabel' => 'Cere ofertă',
])

@push('head')
@php
    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Acasă', 'item' => url('/')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Înlocuire parbriz '.$city->name, 'item' => $city->url()],
                ],
            ],
            [
                '@type' => 'Service',
                'name' => 'Înlocuire parbriz '.$city->name,
                'serviceType' => 'Înlocuire și reparație parbriz',
                'description' => $city->meta_description ?: $city->intro,
                'provider' => ['@id' => url('/').'#organization'],
                'areaServed' => ['@type' => 'City', 'name' => $city->name],
                'url' => $city->url(),
            ],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
@endsection
