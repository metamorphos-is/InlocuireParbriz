@extends('layouts.public')

@section('title', 'Întrebări frecvente despre parbriz: preț, reparație, montaj | inlocuireparbriz.ro')
@section('description', 'Răspunsuri scurte la cele mai frecvente întrebări despre parbriz: cât costă, când se repară o ciobitură, cât durează montajul, calibrarea ADAS, CASCO și ITP.')
@section('og_image', 'parbriz-ploaie-senzor')

@section('content')
@include('partials.page-title', [
    'title' => 'Întrebări frecvente despre parbriz',
    'lead' => 'Cele mai des întâlnite întrebări despre înlocuirea și reparația parbrizului, cu răspunsuri scurte și linkuri spre explicațiile complete.',
    'crumbs' => [['Acasă', route('home')], ['Întrebări frecvente', null]],
])

<section class="ee-section">
    <div class="container ee-narrow">
        @foreach ($groups as $g)
            <h2 class="h3 mt-4 mb-3" id="{{ \Illuminate\Support\Str::slug($g['title']) }}">{{ $g['title'] }}</h2>
            <div class="ee-faq">
                @foreach ($g['items'] as $i)
                    <details class="ee-faq__item">
                        <summary>{{ $i['q'] }}</summary>
                        <p>{{ $i['a'] }}@if ($i['link']) <a href="{{ url($i['link']) }}">Citește mai mult</a>@endif</p>
                    </details>
                @endforeach
            </div>
        @endforeach
    </div>
</section>

@include('partials.cta-banner', [
    'ctaTitle' => 'Nu ai găsit răspunsul?',
    'ctaText' => 'Trimite detaliile mașinii și întrebarea ta — revenim cu explicații și ofertă.',
])

@push('head')
@php
    $graph = [
        ['@type' => 'BreadcrumbList', 'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Acasă', 'item' => url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Întrebări frecvente', 'item' => route('faq')],
        ]],
        ['@type' => 'FAQPage', 'mainEntity' => collect($groups)->flatMap(fn ($g) => $g['items'])->map(fn ($i) => [
            '@type' => 'Question', 'name' => $i['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $i['a']],
        ])->values()->all()],
    ];
@endphp
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
@endsection
