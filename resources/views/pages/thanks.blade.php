@extends('layouts.public')

@section('title', 'Cerere trimisă | inlocuireparbriz.ro')
@section('description', 'Am primit cererea ta. Echipa inlocuireparbriz.ro te contactează în curând.')

@section('content')
<section class="ee-section">
    <div class="container ee-narrow text-center">
        <span class="ee-thanks__icon">@include('partials.icon', ['name' => 'check', 'size' => 40])</span>
        <h1 class="ee-h2">Mulțumim! Am primit cererea ta.</h1>
        @if (session('lead_reference'))
            <p class="ee-lead">Număr de referință: <strong>{{ session('lead_reference') }}</strong></p>
        @endif
        <p>Echipa inlocuireparbriz.ro îți preia cererea și te contactează pe telefonul lăsat în formular.</p>
        <div class="ee-actions justify-content-center">
            <a href="{{ route('home') }}" class="ee-btn ee-btn--amber">Înapoi la prima pagină</a>
            <a href="{{ url('/inlocuire-parbriz-bucuresti') }}" class="ee-btn ee-btn--outline">Vezi serviciile</a>
        </div>
    </div>
</section>
@endsection
