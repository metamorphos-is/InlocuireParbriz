@extends('layouts.public')

@section('title', 'Cere o ofertă pentru parbriz | inlocuireparbriz.ro')
@section('description', 'Completează câteva detalii despre mașină și geamul de care ai nevoie. Dacă poți, atașează fotografii pentru identificarea variantei potrivite.')

@section('content')
<div id="solicita-oferta"></div>
<div id="trimite-detaliile-masinii"></div>
@include('partials.page-title', [
    'title' => 'Cere o ofertă pentru parbrizul mașinii tale',
    'lead' => 'Completează câteva detalii despre mașină și geamul de care ai nevoie. Dacă poți, menționează și fotografii — le putem primi după ce te contactăm.',
    'crumbs' => [['Acasă', route('home')], ['Solicită ofertă', null]],
])

<section class="ee-section">
    <div class="container ee-narrow">
        <div class="ee-panel">
            @include('partials.lead-form', ['selected' => $selected])
        </div>
    </div>
</section>
@endsection
