@extends('layouts.public')

@section('title', 'Parbriz pe marcă și model auto – variante și ofertă | inlocuireparbriz.ro')
@section('description', 'Alege marca și modelul mașinii ca să vezi ce variante de parbriz există (senzor de ploaie, încălzire, cameră ADAS) și cere oferta pe varianta corectă.')
@section('og_image', 'montaj-parbriz-nou-doi-tehnicieni')

@section('content')
@include('partials.page-title', [
    'title' => 'Parbriz pe marcă și model',
    'lead' => 'Același model poate avea mai multe parbrize: simplu, cu senzor de ploaie, încălzit sau cu suport pentru cameră. Alege mașina ta ca să vezi ce variante există și ce trebuie verificat înainte de comandă.',
    'crumbs' => [['Acasă', route('home')], ['Parbriz pe model', null]],
])

<section class="ee-section">
    <div class="container">
        @foreach ($brands as $b)
            <div class="mb-5">
                <h2 class="ip-section-title"><a href="{{ $b->url() }}">Parbriz {{ $b->brand_name }}</a></h2>
                <ul class="ip-city-links">
                    @foreach ($models[$b->brand_slug] ?? [] as $m)
                        <li><a href="{{ $m->url() }}">@include('partials.icon', ['name' => 'windshield', 'size' => 16]) {{ $m->model_name }}@if ($m->years) <small class="text-muted">({{ $m->years }})</small>@endif</a></li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        <div class="ee-prose ip-prose mt-4">
            <h2>Nu găsești modelul tău?</h2>
            <p>Adăugăm pagini noi în fiecare săptămână. Până atunci, poți cere direct oferta: scrie marca, modelul, anul și, dacă o ai, seria de șasiu (VIN). Identificăm parbrizul pentru orice autoturism, SUV sau utilitară, iar oferta și montajul le primești prin atelierele partenere verificate din orașul tău.</p>
            <p>Vezi și: <a href="{{ url('/pret-inlocuire-parbriz') }}">de ce depinde prețul unui parbriz</a>, <a href="{{ url('/calibrare-adas') }}">calibrarea camerei ADAS</a> și <a href="{{ route('faq') }}">întrebări frecvente</a>.</p>
        </div>
    </div>
</section>

@include('partials.cta-banner', [
    'ctaTitle' => 'Ai nevoie de parbriz nou?',
    'ctaText' => 'Trimite marca, modelul și anul mașinii — revenim cu oferta pe varianta corectă.',
])

@push('head')
@php
    $graph = [
        ['@type' => 'BreadcrumbList', 'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Acasă', 'item' => url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Parbriz pe model', 'item' => route('vehicles.index')],
        ]],
        ['@type' => 'CollectionPage', 'name' => 'Parbriz pe marcă și model', 'url' => route('vehicles.index'), 'inLanguage' => 'ro-RO'],
    ];
@endphp
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
@endsection
