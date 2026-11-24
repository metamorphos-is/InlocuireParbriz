@extends('layouts.public')

@section('title', 'Servicii sticlă auto: parbriz, lunetă, geamuri laterale | inlocuireparbriz.ro')
@section('description', 'Toate serviciile pentru sticlă auto: înlocuire parbriz, reparație ciobitură, lunetă și geamuri laterale, calibrare ADAS, montaj la domiciliu, CASCO și flote.')

@section('content')
@include('partials.page-title', [
    'title' => 'Servicii pentru sticlă auto',
    'lead' => 'Alege situația în care ești. Fiecare pagină explică ce presupune lucrarea, ce informații ne trebuie și cum primești oferta prin atelierele partenere verificate din zona ta.',
    'crumbs' => [['Acasă', route('home')], ['Servicii', null]],
])

<section class="ee-section">
    <div class="container">
        <div class="row g-4 mb-2">
            <div class="col-md-4">@include('partials.photo', ['slug' => 'montaj-parbriz-nou-doi-tehnicieni', 'class' => 'ip-photo--card', 'eager' => true, 'sizes' => '(min-width: 768px) 33vw, 100vw'])</div>
            <div class="col-md-4">@include('partials.photo', ['slug' => 'reparatie-ciobitura-parbriz-aplicator', 'class' => 'ip-photo--card', 'sizes' => '(min-width: 768px) 33vw, 100vw'])</div>
            <div class="col-md-4">@include('partials.photo', ['slug' => 'curatare-parbriz-dupa-montaj', 'class' => 'ip-photo--card', 'sizes' => '(min-width: 768px) 33vw, 100vw'])</div>
        </div>
        @foreach (config('navigation.servicii.groups') as $group)
            <h2 class="ip-section-title">{{ $group['title'] }}</h2>
            <div class="ip-service-grid">
                @foreach ($group['items'] as $item)
                    @php($svc = config('inlocuireparbriz.services.'.ltrim($item['url'], '/')))
                    <a class="ip-service-card" href="{{ url($item['url']) }}">
                        <span class="ip-mlink__icon">@include('partials.icon', ['name' => $item['icon'], 'size' => 22])</span>
                        <span class="ip-service-card__title">{{ $item['label'] }}</span>
                        <span class="ip-service-card__text">{{ $svc['short'] ?? $item['hint'] }}</span>
                        <span class="ip-service-card__more">Detalii @include('partials.icon', ['name' => 'arrow', 'size' => 16])</span>
                    </a>
                @endforeach
            </div>
        @endforeach

        <div class="ip-help-box">
            <div>
                <h2 class="ee-h4 mb-1">Nu știi exact de ce serviciu ai nevoie?</h2>
                <p class="mb-0">Descrie avaria și trimite marca, modelul și anul mașinii. Îți spunem dacă e reparație sau înlocuire și ce sticlă se potrivește.</p>
            </div>
            <a href="{{ route('lead.create') }}" class="ip-btn ip-btn--cta">Cere ofertă</a>
        </div>
    </div>
</section>
@endsection
