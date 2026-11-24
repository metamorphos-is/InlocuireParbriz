@extends('layouts.public')

@section('title', $meta['title'])
@section('description', $meta['description'])
@php
    $pageImgs = \App\Support\Img::forPath(request()->path());
@endphp

@section('content')
@php
    $related = collect(config('inlocuireparbriz.services', []))
        ->reject(fn ($s, $key) => $key === $slug)
        ->take(4);
@endphp
<section class="ee-page-hero">
    <div class="container">
        <nav class="ee-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Acasă</a>
            <span>/</span>
            <span>{{ $meta['h1'] }}</span>
        </nav>
        <div class="row g-4 g-lg-5 align-items-center">
            <div class="{{ $pageImgs ? 'col-lg-7' : 'col-12' }}">
                <h1>{{ $meta['h1'] }}</h1>
                <p class="ee-lead">{{ $page['intro'] ?? $meta['description'] }}</p>
                <div class="ee-hero__actions">
                    <a href="{{ $slug === 'despre-noi' ? route('lead.create') : route('lead.create', ['serviciu' => $slug]) }}" class="ee-btn ee-btn--amber ee-btn--lg">{{ $cta[0] }}</a>
                    <a href="{{ route('lead.create') }}" class="ee-btn ee-btn--ghost ee-btn--lg">Trimite detaliile mașinii</a>
                </div>
            </div>
            @if ($pageImgs)
                <div class="col-lg-5">
                    @include('partials.photo', ['slug' => $pageImgs[0], 'eager' => true, 'class' => 'ip-photo--hero', 'sizes' => '(min-width: 992px) 520px, 100vw'])
                </div>
            @endif
        </div>
    </div>
</section>

<section class="ee-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="ee-prose ip-prose">
                    @if (! empty($page['items']))
                        <h2>Ce include serviciul</h2>
                        <ul>
                            @foreach ($page['items'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @foreach ($page['sections'] ?? [] as $si => [$heading, $body])
                        <h2>{{ $heading }}</h2>
                        <p>{{ $body }}</p>
                        @if ($si === 0 && isset($pageImgs[1]))
                            @include('partials.photo', ['slug' => $pageImgs[1], 'class' => 'ip-photo--inline', 'sizes' => '(min-width: 992px) 760px, 100vw', 'caption' => \App\Support\Img::get($pageImgs[1])['alt']])
                        @endif
                        @if ($si === 2 && isset($pageImgs[2]))
                            @include('partials.photo', ['slug' => $pageImgs[2], 'class' => 'ip-photo--inline', 'sizes' => '(min-width: 992px) 760px, 100vw', 'caption' => \App\Support\Img::get($pageImgs[2])['alt']])
                        @endif
                    @endforeach

                    @if (($page['show_sectors'] ?? false) && ($sectors ?? collect())->isNotEmpty())
                        <h2>Zone în București</h2>
                        <p>Putem organiza montajul în Sectorul 1, Sectorul 2, Sectorul 3, Sectorul 4, Sectorul 5 și Sectorul 6, în funcție de adresă și de condițiile lucrării. Fiecare sector are o pagină cu detalii locale.</p>
                        <div class="ee-sector-row">
                            @foreach ($sectors as $s)
                                @php $num = (int) str_replace('sector-', '', $s->slug); @endphp
                                <a href="{{ url('/inlocuire-parbriz-bucuresti/'.$s->slug) }}">Sectorul {{ $num }}</a>
                            @endforeach
                        </div>
                    @endif

                    @if ($slug === 'inlocuire-parbriz-ilfov')
                        <h2>Ilfov — disponibilitate pe localitate</h2>
                        <p>Nu pretindem că acoperim automat tot județul. Scrie localitatea în formular; confirmăm în ofertă dacă și în ce condiții putem organiza montajul.</p>
                    @endif
                </div>

                @if ($slug !== 'despre-noi')
                    <div class="mt-5">
                        <h2 class="h3 mb-3">Cum obții oferta</h2>
                        @include('partials.process-steps', ['steps' => [
                            ['Trimite detaliile', 'Marcă, model, an și tipul de geam.'],
                            ['Verificăm sticla', 'Compatibilitate și, unde e cazul, dotările.'],
                            ['Primești oferta', 'Te contactăm cu detaliile și opțiunile.'],
                        ]])
                    </div>
                @endif
            </div>
            <div class="col-lg-4">
                <aside class="ee-panel ee-panel--sticky">
                    <h2 class="ee-panel__title">{{ $cta[0] }}</h2>
                    <p class="ee-panel__text">{{ $cta[1] }}</p>
                    <a href="{{ $slug === 'despre-noi' ? route('lead.create') : route('lead.create', ['serviciu' => $slug]) }}" class="ee-btn ee-btn--amber w-100">Solicită ofertă</a>
                    <p class="ee-help mt-3 mb-0">Fără prețuri inventate. Oferta se face după datele mașinii.</p>
                </aside>
            </div>
        </div>
    </div>
</section>

@if ($related->isNotEmpty() && $slug !== 'despre-noi')
<section class="ee-section ee-section--alt">
    <div class="container">
        <div class="ee-section__head">
            <h2>Servicii conexe</h2>
        </div>
        <div class="row g-3">
            @foreach ($related as $rSlug => $r)
                <div class="col-md-6 col-lg-3">
                    <a class="ee-service-card" href="{{ url('/'.$rSlug) }}">
                        <h3>{{ $r['nav_label'] ?? $r['name'] }}</h3>
                        <p>{{ $r['short'] }}</p>
                        <span class="ee-service-card__cta">Vezi pagina →</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if (! empty($page['faq']))
<section class="ee-section" id="intrebari">
    <div class="container ee-narrow">
        <div class="ee-section__head">
            <h2>Întrebări frecvente</h2>
        </div>
        <div class="ee-faq">
            @foreach ($page['faq'] as [$q, $a])
                <details class="ee-faq__item">
                    <summary>{{ $q }}</summary>
                    <p>{{ $a }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
@push('head')
@php
    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn ($i) => [
            '@type' => 'Question',
            'name' => $i[0],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $i[1]],
        ], $page['faq']),
    ];
    $serviceSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $meta['h1'],
        'description' => $meta['description'],
        'provider' => ['@id' => url('/').'#organization'],
        'areaServed' => ['@type' => 'City', 'name' => 'București'],
        'url' => url()->current(),
    ];
@endphp
<script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
<script type="application/ld+json">{!! json_encode($serviceSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
@endif

@include('partials.cta-banner', [
    'ctaTitle' => $cta[0],
    'ctaText' => $cta[1],
    'ctaLabel' => 'Solicită ofertă',
])
@endsection
