@php
    $bucOpen = request()->is('inlocuire-parbriz-bucuresti*');
    $servicesOpen = request()->is(
        'inlocuire-parbriz-la-domiciliu',
        'reparatie-parbriz',
        'inlocuire-luneta-si-geamuri-laterale',
        'calibrare-adas',
        'parbrize-flote-firme',
        'parbriz-pe-casco',
        'pret-inlocuire-parbriz',
        'inlocuire-parbriz-bucuresti'
    );
    $pretOpen = request()->is('pret-inlocuire-parbriz');
    $sectorBlurbs = [
        1 => 'Dorobanți, Aviatorilor, Băneasa — montaj la adresă când spațiul permite.',
        2 => 'Colentina, Obor, Tei, Floreasca — confirmăm accesul la locul mașinii.',
        3 => 'Titan, Dristor, Vitan — potrivit pentru șoferi și firme din zonă.',
        4 => 'Berceni, Tineretului, Olteniței — stabilim locul de montaj din timp.',
        5 => 'Cotroceni, Rahova, 13 Septembrie — pe străzi înguste propunem alternative.',
        6 => 'Drumul Taberei, Militari, Giulești — detalii de acces în ansambluri.',
    ];
@endphp
<header class="ee-header">
    <div class="container ee-header__inner">
        <a class="ee-logo" href="{{ route('home') }}" aria-label="Înlocuire Parbriz — pagina principală">
            <span class="ee-logo__mark" aria-hidden="true">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M3 12h18M5 7h14l1 5-1 5H5l-1-5 1-5z"/><path d="M8 12v5M16 12v5"/></svg>
            </span>
            <span class="ee-logo__text">Înlocuire<strong>Parbriz</strong></span>
        </a>

        <button class="ee-nav-toggle d-lg-none" type="button" aria-expanded="false" aria-controls="ee-nav" data-nav-toggle>
            <span class="visually-hidden">Meniu</span>
            <span class="ee-nav-toggle__bar"></span>
            <span class="ee-nav-toggle__bar"></span>
            <span class="ee-nav-toggle__bar"></span>
        </button>

        <nav class="ee-nav" id="ee-nav" aria-label="Navigare principală" data-nav>
            <ul class="ee-nav__list">
                <li>
                    <a href="{{ route('home') }}" @class(['ee-nav__link', 'is-active' => request()->routeIs('home')])>Acasă</a>
                </li>

                {{-- MEGA: Servicii --}}
                <li class="ee-nav__item--mega" data-nav-drop>
                    <button type="button" class="ee-nav__link ee-nav__drop-btn @if($servicesOpen && !request()->is('inlocuire-parbriz-bucuresti/sector*')) is-active @endif" aria-expanded="false" aria-controls="mega-servicii" data-nav-drop-btn>
                        Servicii
                    </button>
                    <div class="ee-mega" id="mega-servicii" data-nav-drop-panel>
                        <div class="ee-mega__grid">
                            <div>
                                <h3 class="ee-mega__heading">Înlocuire parbriz</h3>
                                <ul class="ee-mega__list">
                                    <li><a href="{{ url('/inlocuire-parbriz-bucuresti') }}"><strong>Înlocuire parbriz București</strong><span>Schimbare parbriz în Capitală</span></a></li>
                                    <li><a href="{{ url('/inlocuire-parbriz-la-domiciliu') }}"><strong>Înlocuire parbriz la domiciliu</strong><span>Montaj mobil când condițiile permit</span></a></li>
                                    <li><a href="{{ url('/pret-inlocuire-parbriz') }}"><strong>Preț înlocuire parbriz</strong><span>Ce influențează costul</span></a></li>
                                    <li><a href="{{ url('/parbriz-pe-casco') }}"><strong>Parbriz pe CASCO</strong><span>Ofertă pentru dosarul de daună</span></a></li>
                                </ul>
                            </div>
                            <div>
                                <h3 class="ee-mega__heading">Reparații și geamuri auto</h3>
                                <ul class="ee-mega__list">
                                    <li><a href="{{ url('/reparatie-parbriz') }}"><strong>Reparație parbriz</strong><span>Ciobituri și impacturi mici</span></a></li>
                                    <li><a href="{{ url('/inlocuire-luneta-si-geamuri-laterale') }}"><strong>Înlocuire lunetă</strong><span>Geam spate, inclusiv cu încălzire</span></a></li>
                                    <li><a href="{{ url('/inlocuire-luneta-si-geamuri-laterale') }}"><strong>Înlocuire geamuri laterale</strong><span>Geam portieră și geam fix</span></a></li>
                                    <li><a href="{{ url('/inlocuire-luneta-si-geamuri-laterale') }}"><strong>Schimbare geam portieră</strong><span>Precizează poziția în formular</span></a></li>
                                </ul>
                            </div>
                            <div>
                                <h3 class="ee-mega__heading">Servicii specializate</h3>
                                <ul class="ee-mega__list">
                                    <li><a href="{{ url('/calibrare-adas') }}"><strong>Calibrare ADAS</strong><span>După schimbarea parbrizului</span></a></li>
                                    <li><a href="{{ url('/parbrize-flote-firme') }}"><strong>Parbrize pentru firme și flote</strong><span>Cereri centralizate</span></a></li>
                                </ul>
                            </div>
                            <div class="ee-mega__cta-col">
                                <p class="ee-mega__blurb">Trimite marca, modelul și anul mașinii. Verificăm tipul de geam și îți pregătim oferta.</p>
                                <a href="{{ route('lead.create') }}" class="ee-btn ee-btn--amber ee-btn--block">Solicită ofertă</a>
                                <a href="{{ route('lead.create') }}" class="ee-mega__secondary">Trimite detaliile mașinii →</a>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- MEGA: Înlocuire parbriz București + sectoare --}}
                <li class="ee-nav__item--mega" data-nav-drop>
                    <a href="{{ url('/inlocuire-parbriz-bucuresti') }}" class="ee-nav__link ee-nav__link--split @if($bucOpen) is-active @endif">Înlocuire parbriz București</a>
                    <button type="button" class="ee-nav__chevron" aria-expanded="false" aria-controls="mega-bucuresti" data-nav-drop-btn aria-label="Deschide meniul București">
                        <span aria-hidden="true">▾</span>
                    </button>
                    <div class="ee-mega ee-mega--sectors" id="mega-bucuresti" data-nav-drop-panel>
                        <div class="ee-mega__intro">
                            <h3 class="ee-mega__heading">Înlocuire parbriz în București — toate sectoarele</h3>
                            <p>Servicii de înlocuire parbriz în București, în sectoarele 1–6. Selectează zona pentru informații și solicitări.</p>
                        </div>
                        <div class="ee-mega__grid ee-mega__grid--2">
                            <div>
                                <h4 class="ee-mega__sub">Sectoarele 1–3</h4>
                                <ul class="ee-mega__list">
                                    @foreach ([1, 2, 3] as $n)
                                        <li>
                                            <a href="{{ url('/inlocuire-parbriz-bucuresti/sector-'.$n) }}">
                                                <strong>Înlocuire parbriz Sector {{ $n }}</strong>
                                                <span>{{ $sectorBlurbs[$n] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div>
                                <h4 class="ee-mega__sub">Sectoarele 4–6</h4>
                                <ul class="ee-mega__list">
                                    @foreach ([4, 5, 6] as $n)
                                        <li>
                                            <a href="{{ url('/inlocuire-parbriz-bucuresti/sector-'.$n) }}">
                                                <strong>Înlocuire parbriz Sector {{ $n }}</strong>
                                                <span>{{ $sectorBlurbs[$n] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="ee-mega__foot">
                            <a href="{{ url('/inlocuire-parbriz-bucuresti') }}">Vezi toate serviciile de înlocuire parbriz în București →</a>
                            <a href="{{ url('/inlocuire-parbriz-ilfov') }}"><strong>Înlocuire parbriz în Ilfov</strong></a>
                        </div>
                    </div>
                </li>

                <li>
                    <a href="{{ url('/inlocuire-parbriz-la-domiciliu') }}" @class(['ee-nav__link', 'is-active' => request()->is('inlocuire-parbriz-la-domiciliu')])>La domiciliu</a>
                </li>

                <li class="ee-nav__item--mega ee-nav__item--compact" data-nav-drop>
                    <button type="button" class="ee-nav__link ee-nav__drop-btn @if($pretOpen) is-active @endif" aria-expanded="false" aria-controls="mega-preturi" data-nav-drop-btn>
                        Prețuri
                    </button>
                    <div class="ee-mega ee-mega--sm" id="mega-preturi" data-nav-drop-panel>
                        <ul class="ee-mega__list">
                            <li><a href="{{ url('/pret-inlocuire-parbriz') }}"><strong>Preț înlocuire parbriz</strong><span>Ce influențează costul</span></a></li>
                            <li><a href="{{ route('lead.create') }}"><strong>Solicită ofertă personalizată</strong><span>După datele mașinii tale</span></a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="{{ url('/despre-noi') }}" @class(['ee-nav__link', 'is-active' => request()->is('despre-noi')])>Despre noi</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" @class(['ee-nav__link', 'is-active' => request()->routeIs('contact')])>Contact</a>
                </li>
            </ul>
            <a href="{{ route('lead.create') }}" class="ee-btn ee-btn--amber ee-nav__cta">Solicită ofertă</a>
        </nav>
    </div>
</header>
