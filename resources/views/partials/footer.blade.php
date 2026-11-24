@php
    $company = \App\Support\Company::all();
    $footerCities = collect(\App\Support\Navigation::locationRegions())
        ->reject(fn ($r) => in_array($r['key'] ?? '', ['bucuresti', 'ilfov', 'alte'], true))
        ->flatMap(fn ($r) => $r['items'] ?? [])->take(9);
@endphp
<footer class="ee-footer">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-6 col-lg-3">
                <a class="ee-logo ee-logo--light" href="{{ route('home') }}">
                    <span class="ee-logo__text">Înlocuire<strong>Parbriz</strong></span>
                </a>
                <p class="ee-footer__text mt-3">Înlocuire și reparație parbrize, lunete și geamuri laterale. Trimiți detaliile mașinii, iar oferta și montajul vin prin atelierele partenere verificate din zona ta.</p>
                <a href="{{ route('lead.create') }}" class="ee-btn ee-btn--amber mt-2">Solicită ofertă</a>
            </div>
            <div class="col-6 col-lg-3">
                <h2 class="ee-footer__title">Servicii</h2>
                <ul class="ee-footer__list">
                    <li><a href="{{ route('lead.create') }}">Înlocuire parbriz</a></li>
                    <li><a href="{{ url('/inlocuire-parbriz-la-domiciliu') }}">Înlocuire parbriz la domiciliu</a></li>
                    <li><a href="{{ url('/reparatie-parbriz') }}">Reparație parbriz</a></li>
                    <li><a href="{{ url('/inlocuire-luneta-si-geamuri-laterale') }}">Înlocuire lunetă</a></li>
                    <li><a href="{{ url('/inlocuire-luneta-si-geamuri-laterale') }}">Geamuri laterale</a></li>
                    <li><a href="{{ url('/calibrare-adas') }}">Calibrare ADAS</a></li>
                    <li><a href="{{ url('/parbriz-pe-casco') }}">Parbriz CASCO</a></li>
                    <li><a href="{{ url('/parbrize-flote-firme') }}">Flote auto</a></li>
                    <li><a href="{{ url('/pret-inlocuire-parbriz') }}">Prețuri</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-3">
                <h2 class="ee-footer__title">Parbrize în orașul tău</h2>
                <ul class="ee-footer__list">
                    <li><a href="{{ url('/inlocuire-parbriz-bucuresti') }}">Parbrize București</a></li>
                    @foreach ($footerCities as $c)
                        <li><a href="{{ url($c['url']) }}">Parbrize {{ $c['label'] }}</a></li>
                    @endforeach
                    <li><a href="{{ url('/#orase') }}">Toate orașele →</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-3">
                <h2 class="ee-footer__title">Informații</h2>
                <ul class="ee-footer__list">
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li><a href="{{ url('/despre-noi') }}">Despre noi</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="{{ route('lead.create') }}">Solicită ofertă</a></li>
                    <li><a href="{{ route('privacy') }}">Politica de confidențialitate</a></li>
                </ul>
                <ul class="ee-footer__list mt-3">
                    @if (filled($company['phone']))
                        <li><a href="tel:{{ \App\Support\Company::phoneHref() }}" data-track="phone_click">{{ $company['phone'] }}</a></li>
                    @endif
                    @if (filled($company['email']))
                        <li><a href="mailto:{{ $company['email'] }}" data-track="email_click">{{ $company['email'] }}</a></li>
                    @endif
                    @if (filled($company['hours']))
                        <li>{{ $company['hours'] }}</li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="ee-footer__bottom">
            <span>&copy; {{ date('Y') }} {{ $company['brand'] }}@if (filled($company['legal_name'])) · {{ $company['legal_name'] }}@endif @if (filled($company['cui'])) · CUI {{ $company['cui'] }}@endif @if (filled($company['reg_com'])) · {{ $company['reg_com'] }}@endif</span>
            <a href="{{ route('privacy') }}">Confidențialitate</a>
        </div>
    </div>
</footer>
