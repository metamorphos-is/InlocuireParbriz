@php
    $nav = config('navigation');
    $company = \App\Support\Company::all();
    $path = '/'.ltrim(request()->path(), '/');
    $isActive = fn (string $url) => $url !== '/' && (rtrim($path, '/') === rtrim(parse_url($url, PHP_URL_PATH), '/') || str_starts_with($path, rtrim(parse_url($url, PHP_URL_PATH), '/').'/'));
    $servicesActive = collect($nav['servicii']['groups'])->flatMap(fn ($g) => $g['items'])->contains(fn ($i) => $isActive($i['url'])) || $isActive('/servicii');
    $locationsActive = collect($nav['locatii']['regions'])->contains(fn ($r) => $isActive($r['main']['url']));
@endphp
<header class="ip-header" data-ip-header>
    <div class="container ip-header__bar">
        <a class="ip-logo" href="{{ route('home') }}" aria-label="{{ $company['brand'] }} — pagina principală">
            <span class="ip-logo__mark" aria-hidden="true">@include('partials.icon', ['name' => 'windshield', 'size' => 22])</span>
            <span class="ip-logo__text">Înlocuire<strong>Parbriz</strong><small>Sticlă auto, montată corect</small></span>
        </a>

        <nav class="ip-nav" id="ip-nav" aria-label="Navigare principală" data-ip-nav>
            <ul class="ip-nav__list">
                {{-- Servicii --}}
                <li class="ip-nav__item" data-ip-drop>
                    <button type="button" @class(['ip-nav__link', 'is-active' => $servicesActive]) aria-expanded="false" aria-controls="ip-mega-servicii" data-ip-drop-btn>
                        @include('partials.icon', ['name' => $nav['servicii']['icon'], 'size' => 18])
                        <span>{{ $nav['servicii']['label'] }}</span>
                        <span class="ip-nav__chev">@include('partials.icon', ['name' => 'chevron', 'size' => 16])</span>
                    </button>
                    <div class="ip-mega" id="ip-mega-servicii" data-ip-drop-panel>
                        <div class="ip-mega__inner">
                            <div class="ip-mega__head">
                                <span class="ip-mega__head-icon">@include('partials.icon', ['name' => $nav['servicii']['icon'], 'size' => 24])</span>
                                <div>
                                    <p class="ip-mega__title">{{ $nav['servicii']['title'] }}</p>
                                    <p class="ip-mega__desc">{{ $nav['servicii']['description'] }}</p>
                                </div>
                                <a class="ip-btn ip-btn--ghost ip-mega__all" href="{{ url($nav['servicii']['all']['url']) }}">{{ $nav['servicii']['all']['label'] }} @include('partials.icon', ['name' => 'arrow', 'size' => 16])</a>
                            </div>
                            <div class="ip-mega__cols">
                                @foreach ($nav['servicii']['groups'] as $group)
                                    <div class="ip-mega__col">
                                        <p class="ip-mega__group">{{ $group['title'] }}</p>
                                        <ul class="ip-mega__links">
                                            @foreach ($group['items'] as $item)
                                                <li>
                                                    <a href="{{ url($item['url']) }}" @class(['ip-mlink', 'is-active' => $isActive($item['url'])])>
                                                        <span class="ip-mlink__icon">@include('partials.icon', ['name' => $item['icon'], 'size' => 20])</span>
                                                        <span><strong>{{ $item['label'] }}</strong><small>{{ $item['hint'] }}</small></span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="ip-mega__foot">
                            <div class="container ip-mega__foot-inner">
                                <span>{{ $nav['servicii']['footer']['text'] }}</span>
                                <a href="{{ url($nav['servicii']['footer']['url']) }}">{{ $nav['servicii']['footer']['cta'] }} @include('partials.icon', ['name' => 'arrow', 'size' => 16])</a>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- Locații --}}
                <li class="ip-nav__item" data-ip-drop>
                    <button type="button" @class(['ip-nav__link', 'is-active' => $locationsActive]) aria-expanded="false" aria-controls="ip-mega-locatii" data-ip-drop-btn>
                        @include('partials.icon', ['name' => $nav['locatii']['icon'], 'size' => 18])
                        <span>{{ $nav['locatii']['label'] }}</span>
                        <span class="ip-nav__chev">@include('partials.icon', ['name' => 'chevron', 'size' => 16])</span>
                    </button>
                    <div class="ip-mega ip-mega--split" id="ip-mega-locatii" data-ip-drop-panel>
                        <div class="ip-mega__inner ip-loc" data-ip-tabs>
                            <ul class="ip-loc__tabs" role="tablist">
                                @foreach ($nav['locatii']['regions'] as $i => $region)
                                    <li>
                                        <button type="button" role="tab" id="ip-loc-tab-{{ $region['key'] }}" aria-controls="ip-loc-panel-{{ $region['key'] }}" aria-selected="{{ $i === 0 ? 'true' : 'false' }}" @class(['ip-loc__tab', 'is-active' => $i === 0]) data-ip-tab="{{ $region['key'] }}">
                                            @include('partials.icon', ['name' => $region['icon'], 'size' => 20])
                                            <span>{{ $region['label'] }}</span>
                                            @if (count($region['items']))<em>{{ count($region['items']) }}</em>@endif
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="ip-loc__panels">
                                @foreach ($nav['locatii']['regions'] as $i => $region)
                                    <div class="ip-loc__panel" role="tabpanel" id="ip-loc-panel-{{ $region['key'] }}" aria-labelledby="ip-loc-tab-{{ $region['key'] }}" data-ip-panel="{{ $region['key'] }}" @if ($i !== 0) hidden @endif>
                                        <div class="ip-loc__head">
                                            <p class="ip-mega__title">{{ $region['title'] }}</p>
                                            <p class="ip-mega__desc">{{ $region['description'] }}</p>
                                        </div>
                                        @if (count($region['items']))
                                            <ul class="ip-loc__grid">
                                                @foreach ($region['items'] as $item)
                                                    <li>
                                                        <a href="{{ url($item['url']) }}" @class(['ip-mlink', 'ip-mlink--compact', 'is-active' => $isActive($item['url'])])>
                                                            <span class="ip-mlink__icon">@include('partials.icon', ['name' => 'pin', 'size' => 18])</span>
                                                            <span><strong>Înlocuire parbriz {{ $item['label'] }}</strong><small>{{ $item['hint'] }}</small></span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        <a class="ip-loc__main" href="{{ url($region['main']['url']) }}">{{ $region['main']['label'] }} @include('partials.icon', ['name' => 'arrow', 'size' => 16])</a>
                                    </div>
                                @endforeach
                            </div>
                            <a class="ip-loc__card" href="{{ url($nav['locatii']['card']['url']) }}">
                                <span class="ip-loc__card-kicker">{{ $nav['locatii']['card']['kicker'] }}</span>
                                <span class="ip-loc__card-title">{{ $nav['locatii']['card']['title'] }}</span>
                                <span class="ip-loc__card-arrow">@include('partials.icon', ['name' => 'arrow', 'size' => 18])</span>
                            </a>
                        </div>
                        <div class="ip-mega__foot">
                            <div class="container ip-mega__foot-inner">
                                <span>Orașul tău nu e în listă? Trimite cererea — îți confirmăm disponibilitatea unui atelier partener.</span>
                                <a href="{{ url('/cerere-oferta?zona=alt_oras') }}">Cere ofertă @include('partials.icon', ['name' => 'arrow', 'size' => 16])</a>
                            </div>
                        </div>
                    </div>
                </li>

                @foreach ($nav['simple'] as $link)
                    <li class="ip-nav__item">
                        <a href="{{ url($link['url']) }}" @class(['ip-nav__link', 'is-active' => $isActive($link['url'])])>
                            @include('partials.icon', ['name' => $link['icon'], 'size' => 18])
                            <span>{{ $link['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="ip-nav__actions">
                @if (filled($company['phone']))
                    <a class="ip-phone" href="tel:{{ \App\Support\Company::phoneHref() }}" data-track="phone_click">
                        @include('partials.icon', ['name' => 'phone', 'size' => 18])
                        <span>{{ $company['phone'] }}</span>
                    </a>
                @endif
                <a href="{{ route('lead.create') }}" class="ip-btn ip-btn--cta" data-track="cta_header">Cere ofertă</a>
            </div>
        </nav>

        <button class="ip-burger" type="button" aria-expanded="false" aria-controls="ip-nav" data-ip-burger>
            <span class="visually-hidden">Deschide meniul</span>
            <span></span><span></span><span></span>
        </button>
    </div>
</header>
