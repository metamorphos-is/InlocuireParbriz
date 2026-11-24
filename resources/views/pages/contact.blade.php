@extends('layouts.public')

@section('title', 'Contact | inlocuireparbriz.ro')
@section('description', 'Ai nevoie de un parbriz nou, de o reparație sau de înlocuirea unui geam lateral? Trimite detaliile mașinii și îți răspundem pentru ofertă și programare.')

@section('content')
@include('partials.page-title', [
    'title' => 'Contact | inlocuireparbriz.ro',
    'lead' => 'Ai nevoie de un parbriz nou, de o reparație sau de înlocuirea unui geam lateral? Trimite-ne detaliile mașinii și îți răspundem pentru a discuta oferta și programarea.',
    'crumbs' => [['Acasă', route('home')], ['Contact', null]],
])

<section class="ee-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                @php($company = \App\Support\Company::display())
                <div class="ee-feature ee-feature--stack">
                    <span class="ee-feature__icon">@include('partials.icon', ['name' => 'form', 'size' => 22])</span>
                    <div>
                        <h2 class="ee-h4">Date de contact</h2>
                        <p>
                            @if (filled($company['phone']))Telefon: <a href="tel:{{ \App\Support\Company::phoneHref() }}" data-track="phone_click">{{ $company['phone'] }}</a><br>@endif
                            @if (filled($company['email']))Email: <a href="mailto:{{ $company['email'] }}" data-track="email_click">{{ $company['email'] }}</a><br>@endif
                            @if (filled($company['hours'])){{ $company['hours'] }}<br>@endif
                            @if (filled($company['address'])){{ $company['address'] }}@endif
                        </p>
                        <p class="mb-0">Cel mai rapid: formularul de alături, cu detaliile mașinii.</p>
                    </div>
                </div>
                <div class="ee-feature ee-feature--stack">
                    <span class="ee-feature__icon">@include('partials.icon', ['name' => 'pin', 'size' => 22])</span>
                    <div>
                        <h2 class="ee-h4">Zone deservite</h2>
                        <p>Cereri din toată țara, cu pagini dedicate pentru București, Ilfov și <a href="{{ url('/#orase') }}">orașele mari</a>. Din orice altă localitate, trimite cererea și îți confirmăm disponibilitatea unui atelier partener în zona ta.</p>
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
