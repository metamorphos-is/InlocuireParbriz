<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'InlocuireParbriz — Înlocuire parbriz București')</title>
    <meta name="description" content="@yield('description', 'InlocuireParbriz: înlocuire și reparații parbrize în București, montaj la domiciliu când condițiile permit.')">

    {{-- Pre-lansare: noindex pe toate paginile publice (vezi și middleware ForceNoIndex + robots.txt) --}}
    <meta name="robots" content="noindex, nofollow">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <meta property="og:locale" content="ro_RO">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="InlocuireParbriz">
    <meta property="og:title" content="@yield('title', 'InlocuireParbriz — Înlocuire parbriz București')">
    <meta property="og:description" content="@yield('description', 'Trimite o cerere pentru înlocuire sau reparație parbriz în București.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="theme-color" content="#0F2A4A">

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/favicon.svg') }}">
    <link rel="preload" href="{{ asset('assets/fonts/manrope-latin-800.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/inlocuireparbriz.css') }}?v=20261124d">
    <link rel="stylesheet" href="{{ asset('assets/css/menu.css') }}?v=20261124d">

    @include('partials.schema-localbusiness')
    @stack('head')
</head>
<body>
    <a class="ee-skip" href="#continut">Sari la conținut</a>

    @include('partials.header')

    <main id="continut">
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Bară CTA fixă, doar pe mobil --}}
    <div class="ee-sticky-cta d-lg-none">
        <a href="{{ route('lead.create') }}" class="ee-btn ee-btn--amber ee-btn--block">Solicită ofertă @include('partials.icon', ['name' => 'arrow', 'size' => 18])</a>
    </div>

    <script src="{{ asset('assets/js/inlocuireparbriz.js') }}?v=20261124d" defer></script>
    @stack('scripts')
</body>
</html>
