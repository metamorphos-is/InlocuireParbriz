@extends('layouts.public')

@section('title', ($category ? \App\Models\Post::CATEGORIES[$category].' – blog despre parbrize' : 'Blog despre parbrize').': ghiduri, reparații și sfaturi | inlocuireparbriz.ro')
@section('description', 'Ghiduri despre parbrize: ce faci la o ciobitură sau o fisură, cum alegi sticla potrivită, cât durează montajul și când e nevoie de calibrare ADAS.')

@section('content')
<section class="ip-hero">
    <div class="container">
        <nav class="ip-crumbs" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Acasă</a><span aria-hidden="true">›</span>
            @if ($category)
                <a href="{{ route('blog.index') }}">Blog</a><span aria-hidden="true">›</span>
                <span aria-current="page">{{ \App\Models\Post::CATEGORIES[$category] }}</span>
            @else
                <span aria-current="page">Blog</span>
            @endif
        </nav>
        <p class="ip-kicker">@include('partials.icon', ['name' => 'book', 'size' => 16]) Blog</p>
        <h1 class="ip-hero__title">{{ $category ? \App\Models\Post::CATEGORIES[$category] : 'Ghiduri despre parbrize și sticla auto' }}</h1>
        <p class="ip-hero__lead">Răspunsuri clare la ce se întâmplă cu parbrizul tău: ciobituri, fisuri, alegerea sticlei, montaj și calibrare.</p>
        <ul class="ip-filter" aria-label="Categorii">
            <li><a href="{{ route('blog.index') }}" @class(['is-active' => ! $category])>Toate</a></li>
            @foreach (\App\Models\Post::CATEGORIES as $key => $label)
                <li><a href="{{ route('blog.index', ['categorie' => $key]) }}" @class(['is-active' => $category === $key])>{{ $label }}</a></li>
            @endforeach
        </ul>
    </div>
</section>

<section class="ee-section">
    <div class="container">
        @if ($posts->isEmpty())
            <p class="text-muted">Încă nu sunt articole în această categorie.</p>
        @else
            <div class="ip-post-grid">
                @foreach ($posts as $post)
                    <article class="ip-post-card">
                        <p class="ip-post-card__meta">{{ $post->categoryLabel() }} · {{ $post->readingMinutes() }} min de citit</p>
                        <h2 class="ip-post-card__title"><a href="{{ $post->url() }}">{{ $post->title }}</a></h2>
                        <p class="ip-post-card__excerpt">{{ $post->excerpt }}</p>
                        <span class="ip-post-card__more" aria-hidden="true">Citește →</span>
                    </article>
                @endforeach
            </div>
            @if ($posts->hasPages())
                <nav class="ip-pager" aria-label="Pagini">
                    @if ($posts->previousPageUrl())<a href="{{ $posts->previousPageUrl() }}" rel="prev">← Mai noi</a>@endif
                    <span>Pagina {{ $posts->currentPage() }} din {{ $posts->lastPage() }}</span>
                    @if ($posts->nextPageUrl())<a href="{{ $posts->nextPageUrl() }}" rel="next">Mai vechi →</a>@endif
                </nav>
            @endif
        @endif
    </div>
</section>

@include('partials.cta-banner', [
    'ctaTitle' => 'Ai deja nevoie de un parbriz nou?',
    'ctaText' => 'Trimite datele mașinii și primești oferta de la un atelier partener din orașul tău.',
    'ctaLabel' => 'Cere ofertă',
])
@endsection
