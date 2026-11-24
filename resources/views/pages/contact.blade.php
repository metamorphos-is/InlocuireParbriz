@extends('layouts.public')

@section('title', 'Contact – Înlocuire Parbriz')
@section('description', 'Ai nevoie de un parbriz nou, de o reparație sau de înlocuirea unui geam lateral? Trimite detaliile mașinii și îți răspundem pentru ofertă și programare.')

@section('content')
@include('partials.page-title', [
    'title' => 'Contact – Înlocuire Parbriz',
    'lead' => 'Ai nevoie de un parbriz nou, de o reparație sau de înlocuirea unui geam lateral? Trimite-ne detaliile mașinii și îți răspundem pentru a discuta oferta și programarea.',
    'crumbs' => [['Acasă', route('home')], ['Contact', null]],
])

<section class="ee-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="ee-feature ee-feature--stack">
                    <span class="ee-feature__icon">@include('partials.icon', ['name' => 'form', 'size' => 22])</span>
                    <div>
                        <h2 class="ee-h4">Formularul e cel mai rapid canal</h2>
                        <p>Nu publicăm încă un număr de telefon pe site. Completează formularul — te contactăm noi.</p>
                    </div>
                </div>
                <div class="ee-feature ee-feature--stack">
                    <span class="ee-feature__icon">@include('partials.icon', ['name' => 'pin', 'size' => 22])</span>
                    <div>
                        <h2 class="ee-h4">Zone deservite</h2>
                        <p>București — Sectorul 1 până la Sectorul 6. Pentru Ilfov, confirmăm disponibilitatea după localitatea din cerere.</p>
                    </div>
                </div>
                <div class="ee-feature ee-feature--stack">
                    <span class="ee-feature__icon">@include('partials.icon', ['name' => 'shield', 'size' => 22])</span>
                    <div>
                        <h2 class="ee-h4">Datele tale</h2>
                        <p>Le folosim doar pentru cererea ta. Detalii în <a href="{{ route('privacy') }}">politica de confidențialitate</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ee-panel">
                    <h2 class="ee-panel__title">Trimite detaliile mașinii</h2>
                    @include('partials.lead-form')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
