<footer class="ee-footer">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-6 col-lg-3">
                <a class="ee-logo ee-logo--light" href="{{ route('home') }}">
                    <span class="ee-logo__text">Înlocuire<strong>Parbriz</strong></span>
                </a>
                <p class="ee-footer__text mt-3">Înlocuire și reparație parbrize, lunete și geamuri laterale în București. Trimite detaliile mașinii pentru o ofertă pe tipul corect de geam.</p>
                <a href="{{ route('lead.create') }}" class="ee-btn ee-btn--amber mt-2">Solicită ofertă</a>
            </div>
            <div class="col-6 col-lg-3">
                <h2 class="ee-footer__title">Servicii</h2>
                <ul class="ee-footer__list">
                    <li><a href="{{ url('/inlocuire-parbriz-bucuresti') }}">Înlocuire parbriz București</a></li>
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
                <h2 class="ee-footer__title">Înlocuire parbriz București</h2>
                <ul class="ee-footer__list">
                    @foreach (range(1, 6) as $n)
                        <li><a href="{{ url('/inlocuire-parbriz-bucuresti/sector-'.$n) }}">Înlocuire parbriz Sector {{ $n }}</a></li>
                    @endforeach
                    <li><a href="{{ url('/inlocuire-parbriz-ilfov') }}">Înlocuire parbriz Ilfov</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-3">
                <h2 class="ee-footer__title">Informații</h2>
                <ul class="ee-footer__list">
                    <li><a href="{{ url('/despre-noi') }}">Despre noi</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="{{ route('lead.create') }}">Solicită ofertă</a></li>
                    <li><a href="{{ route('privacy') }}">Politica de confidențialitate</a></li>
                </ul>
                <p class="ee-footer__text mt-3 mb-0">București — sectoarele 1–6. Ilfov pe confirmare, după localitate.</p>
            </div>
        </div>
        <div class="ee-footer__bottom">
            <span>&copy; {{ date('Y') }} Înlocuire Parbriz. Toate drepturile rezervate.</span>
            <a href="{{ route('privacy') }}">Confidențialitate</a>
        </div>
    </div>
</footer>
