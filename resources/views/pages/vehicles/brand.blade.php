@extends('layouts.public')

@php
    $brand = $page->brand_name;
    $img = \App\Support\Img::exists($page->image) ? $page->image : 'montaj-parbriz-nou-doi-tehnicieni';
    $leadUrl = route('lead.create', ['serviciu' => 'inlocuire-parbriz-bucuresti', 'marca' => $brand]);
    $faq = array_map(fn ($f) => [$f['q'] ?? '', $f['a'] ?? ''], (array) $page->faq);
@endphp

@section('title', $page->seo_title ?: "Parbriz {$brand} – modele, variante și montaj | inlocuireparbriz.ro")
@section('description', $page->meta_description ?: $page->intro)
@section('og_image', $img)

@section('content')
<section class="ip-hero">
    <div class="container">
        <nav class="ip-crumbs" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Acasă</a><span aria-hidden="true">›</span>
            <a href="{{ route('vehicles.index') }}">Parbriz pe model</a><span aria-hidden="true">›</span>
            <span aria-current="page">{{ $brand }}</span>
        </nav>
        <div class="ip-hero__grid">
            <div>
                <h1 class="ip-hero__title">{{ $page->h1 ?: "Parbriz {$brand}: alege modelul" }}</h1>
                <p class="ip-hero__lead">{{ $page->intro }}</p>
                <div class="ip-hero__actions">
                    <a href="{{ $leadUrl }}" class="ip-btn ip-btn--cta ip-btn--lg" data-track="cta_brand">Cere ofertă pentru {{ $brand }}</a>
                    <a href="#modele" class="ip-btn ip-btn--ghost ip-btn--lg">Vezi modelele</a>
                </div>
            </div>
            @include('partials.photo', ['slug' => $img, 'eager' => true, 'class' => 'ip-photo--hero', 'alt' => \App\Support\Img::get($img)['alt'].' – parbriz '.$brand])
        </div>
    </div>
</section>

<section class="ee-section" id="modele">
    <div class="container">
        <h2 class="ip-section-title">Modele {{ $brand }}</h2>
        <div class="ip-service-grid">
            @foreach ($models as $m)
                <a class="ip-service-card" href="{{ $m->url() }}">
                    <span class="ip-mlink__icon">@include('partials.icon', ['name' => 'windshield', 'size' => 22])</span>
                    <span class="ip-service-card__title">Parbriz {{ $m->model_name }}</span>
                    <span class="ip-service-card__text">{{ $m->years }}@if ($m->years && $m->bodies) · @endif{{ $m->bodies }}</span>
                </a>
            @endforeach
        </div>
        <p class="mt-3">Modelul tău nu e în listă? <a href="{{ $leadUrl }}">Trimite cererea</a> cu modelul și anul — identificăm parbrizul pentru orice mașină {{ $brand }}.</p>
    </div>
</section>

<section class="ee-section ee-section--alt">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="ee-prose ip-prose">
                    @foreach ((array) $page->sections as $s)
                        <h2>{{ $s['heading'] ?? '' }}</h2>
                        <p>{{ $s['body'] ?? '' }}</p>
                    @endforeach
                    <h2>Ce ne trimiți pentru o ofertă corectă</h2>
                    <p>Modelul, anul de fabricație și seria de șasiu (VIN) din talon. Dacă poți, adaugă o fotografie cu zona din spatele oglinzii retrovizoare și una cu eticheta din colțul parbrizului. Cu aceste date verificăm varianta exactă — senzori, cameră, încălzire, bandă colorată — și îți trimitem oferta înainte de orice programare.</p>
                </div>
                @if ($faq)
                    <div class="mt-5">
                        <h2 class="h3 mb-3">Întrebări frecvente — parbriz {{ $brand }}</h2>
                        <div class="ee-faq">
                            @foreach ($faq as [$q, $a])
                                <details class="ee-faq__item"><summary>{{ $q }}</summary><p>{{ $a }}</p></details>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-lg-4">
                <aside class="ee-panel ee-panel--sticky">
                    <h2 class="ee-panel__title">Alte mărci</h2>
                    <ul class="ip-toc">
                        @foreach ($otherBrands as $b)
                            <li><a href="{{ $b->url() }}">Parbriz {{ $b->brand_name }}</a></li>
                        @endforeach
                    </ul>
                    <a href="{{ $leadUrl }}" class="ip-btn ip-btn--cta w-100 mt-3">Cere ofertă</a>
                </aside>
            </div>
        </div>
    </div>
</section>

@include('partials.cta-banner', [
    'ctaTitle' => "Ai nevoie de parbriz pentru {$brand}?",
    'ctaText' => 'Trimite modelul, anul și seria de șasiu — revenim cu oferta pe varianta corectă.',
    'ctaHref' => $leadUrl,
])

@push('head')
@php
    $graph = [
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Acasă', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Parbriz pe model', 'item' => route('vehicles.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $brand, 'item' => $page->url()],
            ],
        ],
        [
            '@type' => 'ItemList',
            'name' => 'Parbrize '.$brand,
            'itemListElement' => $models->values()->map(fn ($m, $i) => ['@type' => 'ListItem', 'position' => $i + 1, 'name' => 'Parbriz '.$m->fullName(), 'url' => $m->url()])->all(),
        ],
    ];
    if ($faq) {
        $graph[] = ['@type' => 'FAQPage', 'mainEntity' => array_map(fn ($f) => ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]], $faq)];
    }
@endphp
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
@endsection
