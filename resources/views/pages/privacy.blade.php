@extends('layouts.public')

@section('title', 'Politica de confidențialitate — Înlocuire Parbriz')
@section('description', 'Cum prelucrează Înlocuire Parbriz datele personale transmise prin formularul de cerere de ofertă.')

@section('content')
@include('partials.page-title', [
    'title' => 'Politica de confidențialitate',
    'crumbs' => [['Acasă', route('home')], ['Politica de confidențialitate', null]],
])

<section class="ee-section">
    <div class="container ee-narrow ee-prose">
        <p><strong>Versiune provizorie.</strong> Datele complete ale operatorului (denumire societate, CUI, sediu, email de contact GDPR) vor fi publicate aici înainte de indexare, după confirmarea firmei.</p>

        <h2>Ce date colectăm</h2>
        <p>Prin formularul de cerere putem colecta: nume, telefon, email (opțional), serviciul dorit, date despre mașină (marcă, model, an, VIN opțional), tipul de geam, dotări, zona (București/Ilfov), sector sau localitate, preferința de montaj și descrierea problemei. Salvăm și o amprentă tehnică (hash) a adresei IP, pentru protecție împotriva abuzurilor.</p>

        <h2>De ce le folosim</h2>
        <p>Folosim datele exclusiv pentru a prelua cererea ta, a te contacta în legătură cu oferta și programarea și a organiza lucrarea. Nu vindem datele către terți în scop de marketing.</p>

        <h2>Temei și păstrare</h2>
        <p>Prelucrarea se bazează pe solicitarea ta (pași precontractuali) și pe consimțământul bifat în formular. Păstrăm datele cât este necesar pentru soluționarea cererii și pentru obligațiile legale aplicabile; detaliile exacte de retenție vor fi completate odată cu datele operatorului.</p>

        <h2>Drepturile tale</h2>
        <p>Ai dreptul de acces, rectificare, ștergere, restricționare, opoziție și plângere la ANSPDCP, conform GDPR. Canalul de contact pentru aceste drepturi va fi publicat pe această pagină la lansare.</p>
    </div>
</section>
@endsection
