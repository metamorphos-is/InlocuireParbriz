<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Înlocuire parbriz în toată țara | inlocuireparbriz.ro')</title>
    <meta name="description" content="@yield('description', 'Înlocuire, schimbare și montaj parbriz prin ateliere partenere verificate din orașul tău.')">

    {{-- Pre-lansare: noindex pe toate paginile publice (vezi și middleware ForceNoIndex + robots.txt) --}}
    <meta name="robots" content="noindex, nofollow">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <meta property="og:locale" content="ro_RO">
    @php
        $ogImg = \App\Support\Img::get(trim($__env->yieldContent('og_image')) ?: (\App\Support\Img::forPath(request()->path())[0] ?? \App\Support\Img::DEFAULT));
    @endphp
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="inlocuireparbriz.ro">
    <meta property="og:title" content="@yield('title', 'Înlocuire parbriz în toată țara | inlocuireparbriz.ro')">
    <meta property="og:description" content="@yield('description', 'Înlocuire, schimbare și montaj parbriz prin ateliere partenere verificate din orașul tău.')">
    <meta property="og:url" content="{{ url()->current() }}">
    @if ($ogImg)
    <meta property="og:image" content="{{ $ogImg['og'] }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $ogImg['alt'] }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="{{ $ogImg['og'] }}">
    <link rel="image_src" href="{{ $ogImg['og'] }}">
    @endif
    <meta name="theme-color" content="#0F2A4A">

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/favicon.svg') }}?v=2">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2" sizes="48x48">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="preload" href="{{ asset('assets/fonts/manrope-latin-800.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/inlocuireparbriz.css') }}?v={{ @filemtime(public_path('assets/css/inlocuireparbriz.css')) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/menu.css') }}?v={{ @filemtime(public_path('assets/css/menu.css')) }}">

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

    <script src="{{ asset('assets/js/inlocuireparbriz.js') }}?v={{ @filemtime(public_path('assets/js/inlocuireparbriz.js')) }}" defer></script>
    @stack('scripts')
</body>
</html>
