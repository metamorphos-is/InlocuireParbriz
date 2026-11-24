@extends('layouts.public')

@section('title', 'Pagina nu a fost găsită — InlocuireParbriz')
@section('description', 'Pagina căutată nu există.')

@section('content')
<section class="ee-section">
    <div class="container ee-narrow text-center">
        <p class="ee-eyebrow ee-eyebrow--dark">Eroare 404</p>
        <h1 class="ee-h2">Pagina nu a fost găsită</h1>
        <p>Adresa nu există sau a fost mutată. Poți continua de la prima pagină sau din lista de servicii.</p>
        <div class="ee-actions justify-content-center">
            <a href="{{ route('home') }}" class="ee-btn ee-btn--amber">Prima pagină</a>
            <a href="{{ route('servicii.index') }}" class="ee-btn ee-btn--outline">Servicii</a>
        </div>
    </div>
</section>
@endsection
