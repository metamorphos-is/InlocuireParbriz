@extends('layouts.public')

@section('title', $meta['title'])
@section('description', $meta['description'])
@php
    $heroes = config('images.city_heroes');
    $sectorImg = $heroes[($n * 3 + 1) % count($heroes)];
    $sectorImg2 = config('images.city_secondary')[$n % count(config('images.city_secondary'))];
@endphp
@section('og_image', $sectorImg)

@section('content')
@php
    $areas = $local['areas'] ?? [];
    $neighbours = $local['neighbours'] ?? [];
@endphp
<section class="ee-page-hero">
    <div class="container">
        <nav class="ee-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Acasă</a>
            <span>/</span>
            <a href="{{ url('/inlocuire-parbriz-bucuresti') }}">Înlocuire parbriz București</a>
            <span>/</span>
            <span>Sector {{ $n }}</span>
        </nav>
        <div class="row g-4 g-lg-5 align-items-center">
            <div class="col-lg-7">
                <h1>Înlocuire parbriz Sector {{ $n }}</h1>
                <p class="ee-lead">{{ $local['intro'] ?? "Servicii de schimbare parbriz în Sectorul {$n} din București — inclusiv montaj la domiciliu, când condițiile de lucru sunt potrivite." }}</p>
                <div class="ee-hero__actions">
                    <a href="{{ route('lead.create', ['sector' => $n]) }}" class="ee-btn ee-btn--amber ee-btn--lg">Cere ofertă pentru Sectorul {{ $n }}</a>
                    <a href="{{ route('lead.create', ['sector' => $n]) }}" class="ee-btn ee-btn--ghost ee-btn--lg">Trimite detaliile mașinii</a>
                </div>
            </div>
            <div class="col-lg-5">
                @include('partials.photo', ['slug' => $sectorImg, 'eager' => true, 'class' => 'ip-photo--hero', 'sizes' => '(min-width: 992px) 520px, 100vw', 'alt' => \App\Support\Img::get($sectorImg)['alt'].' – Sectorul '.$n.', București'])
            </div>
        </div>
    </div>
</section>

<section class="ee-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8 ee-prose ip-prose">
                @if ($areas)
                    <h2>Zone din Sectorul {{ $n }}</h2>
                    <p>Lucrăm în cartiere precum <strong>{{ implode(', ', $areas) }}</strong>, în funcție de adresă și de accesul la mașină. Nu avem sediu separat pe sector — ne deplasăm la locația ta când spațiul și vremea permit un montaj corect.</p>
                @endif

                <h2>Servicii disponibile în Sectorul {{ $n }}</h2>
                <ul>
                    <li><a href="{{ url('/inlocuire-parbriz-bucuresti') }}">Înlocuire parbriz</a> — identificare sticlă după marca, modelul și dotările mașinii</li>
                    <li><a href="{{ url('/inlocuire-parbriz-la-domiciliu') }}">Înlocuire parbriz la domiciliu</a> — montaj mobil când locația permite</li>
                    <li><a href="{{ url('/reparatie-parbriz') }}">Reparație parbriz</a> — evaluare ciobituri și impacturi mici</li>
                    <li><a href="{{ url('/inlocuire-luneta-si-geamuri-laterale') }}">Lunetă și geamuri laterale</a></li>
                    <li><a href="{{ url('/calibrare-adas') }}">Informații despre calibrare ADAS</a>, după caz</li>
                </ul>

                @include('partials.photo', ['slug' => $sectorImg2, 'class' => 'ip-photo--inline', 'sizes' => '(min-width: 992px) 760px, 100vw', 'caption' => \App\Support\Img::get($sectorImg2)['alt']])

                <h2>Montaj la domiciliu în Sectorul {{ $n }}</h2>
                <p>{{ $local['local'] ?? 'Pentru montajul mobil avem nevoie de un loc stabil, cu spațiu pentru deschiderea portierelor. Dacă plouă sau spațiul e prea strâmt, propunem un loc acoperit sau o reprogramare.' }}</p>

                <h2>Ce ne trimiți pentru ofertă</h2>
                <ul>
                    <li>Marca, modelul și anul mașinii</li>
                    <li>Tipul de geam (parbriz, lunetă, lateral)</li>
                    <li>Fotografii cu avaria, dacă le ai</li>
                    <li>Zona din Sectorul {{ $n }} unde se află mașina</li>
                    <li>Preferința: la domiciliu, la birou sau spațiu amenajat</li>
                </ul>

                <h2>Cum obții oferta</h2>
                @include('partials.process-steps', ['steps' => [
                    ['Trimite cererea', "Menționează Sectorul {$n} și datele mașinii."],
                    ['Verificăm sticla', 'Compatibilitate și, unde e cazul, dotările.'],
                    ['Primești oferta', 'Te contactăm cu detaliile și opțiunile de montaj.'],
                ]])

                @if ($neighbours)
                    <h2>Sectoare apropiate</h2>
                    <div class="ee-sector-row">
                        @foreach ($neighbours as $nb)
                            <a href="{{ url('/inlocuire-parbriz-bucuresti/sector-'.$nb) }}">Înlocuire parbriz Sector {{ $nb }}</a>
                        @endforeach
                        <a href="{{ url('/inlocuire-parbriz-bucuresti') }}">Toate zonele București</a>
                    </div>
                @endif
            </div>
            <div class="col-lg-4">
                <aside class="ee-panel ee-panel--sticky">
                    <h2 class="ee-panel__title">Solicită montaj în Sectorul {{ $n }}</h2>
                    <p class="ee-panel__text">Trimite marca, modelul și anul. Confirmăm dacă putem ajunge la adresa ta din Sectorul {{ $n }}.</p>
                    <a href="{{ route('lead.create', ['sector' => $n]) }}" class="ee-btn ee-btn--amber w-100">Solicită ofertă</a>
                </aside>
            </div>
        </div>
    </div>
</section>

<section class="ee-section ee-section--alt" id="intrebari">
    <div class="container ee-narrow">
        <h2>Întrebări pentru Sectorul {{ $n }}</h2>
        <div class="ee-faq">
            <details class="ee-faq__item">
                <summary>Puteți veni la adresa mea din Sectorul {{ $n }}?</summary>
                <p>Da, în multe cazuri. Confirmăm în ofertă, după ce ne spui zona și tipul locului (curte, parcare, subteran).</p>
            </details>
            <details class="ee-faq__item">
                <summary>Trebuie să aduc mașina într-un service?</summary>
                <p>Nu neapărat. Dacă locația permite, putem organiza montajul la tine. Dacă nu, îți propunem o alternativă.</p>
            </details>
            <details class="ee-faq__item">
                <summary>Cum încep o cerere pentru Sectorul {{ $n }}?</summary>
                <p>Completează formularul, alege București și Sectorul {{ $n }}, apoi trimite detaliile mașinii.</p>
            </details>
        </div>
    </div>
</section>

@include('partials.cta-banner', [
    'ctaTitle' => "Înlocuire parbriz Sector {$n} — solicită oferta",
    'ctaText' => 'Trimite marca, modelul și anul mașinii. Confirmăm disponibilitatea pentru adresa ta.',
    'ctaHref' => route('lead.create', ['sector' => $n]),
    'ctaLabel' => 'Solicită ofertă',
])
@endsection
