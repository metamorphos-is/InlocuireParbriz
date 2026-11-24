@extends('layouts.public')

@section('title', $post->seo_title ?: $post->title.' | Înlocuire Parbriz')
@section('description', $post->meta_description ?: $post->excerpt)

@section('content')
@php
    $headings = $post->headings();
    $faq = (array) $post->faq;
@endphp
<section class="ip-hero">
    <div class="container">
        <nav class="ip-crumbs" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Acasă</a><span aria-hidden="true">›</span>
            <a href="{{ route('blog.index') }}">Blog</a><span aria-hidden="true">›</span>
            <a href="{{ route('blog.index', ['categorie' => $post->category]) }}">{{ $post->categoryLabel() }}</a>
        </nav>
        <div class="ip-article-head">
            <h1 class="ip-hero__title">{{ $post->title }}</h1>
            <p class="ip-hero__lead">{{ $post->excerpt }}</p>
            <p class="ip-post-card__meta">
                {{ $post->author ?: 'Echipa Înlocuire Parbriz' }}
                @if ($post->published_at) · <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->translatedFormat('j F Y') }}</time>@endif
                · {{ $post->readingMinutes() }} min de citit
            </p>
        </div>
    </div>
</section>

<section class="ee-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <article class="ee-prose ip-article">
                    {!! $post->html() !!}
                </article>

                @if ($faq)
                    <div class="mt-5">
                        <h2 class="h3 mb-3">Întrebări frecvente</h2>
                        <div class="ee-faq">
                            @foreach ($faq as $item)
                                <details class="ee-faq__item">
                                    <summary>{{ $item['q'] ?? '' }}</summary>
                                    <p>{{ $item['a'] ?? '' }}</p>
                                </details>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-lg-4">
                <aside class="ee-panel ee-panel--sticky">
                    @if (count($headings) > 1)
                        <p class="ip-toc__title">În acest articol</p>
                        <ol class="ip-toc">
                            @foreach ($headings as $h)
                                <li><a href="#{{ $h['id'] }}">{{ $h['text'] }}</a></li>
                            @endforeach
                        </ol>
                        <hr>
                    @endif
                    <h2 class="ee-panel__title">Ai nevoie de ofertă?</h2>
                    <p class="ee-panel__text">Trimite marca, modelul și anul mașinii. Primești oferta de la un atelier partener verificat din orașul tău.</p>
                    <a href="{{ route('lead.create') }}" class="ip-btn ip-btn--cta w-100" data-track="cta_blog_aside">Cere ofertă</a>
                    @if ($post->related_service)
                        <a href="{{ url($post->related_service) }}" class="ip-btn ip-btn--ghost w-100 mt-2">Vezi serviciul</a>
                    @endif
                </aside>
            </div>
        </div>
    </div>
</section>

@if ($related->isNotEmpty())
<section class="ee-section ee-section--alt">
    <div class="container">
        <div class="ip-section-head"><h2 class="ip-section-title">Citește și</h2></div>
        <div class="ip-post-grid">
            @foreach ($related as $r)
                <article class="ip-post-card">
                    <p class="ip-post-card__meta">{{ $r->categoryLabel() }}</p>
                    <h3 class="ip-post-card__title"><a href="{{ $r->url() }}">{{ $r->title }}</a></h3>
                    <p class="ip-post-card__excerpt">{{ $r->excerpt }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('partials.cta-banner', [
    'ctaTitle' => 'Parbriz ciobit, fisurat sau spart?',
    'ctaText' => 'Trimite datele mașinii și o fotografie — îți spunem dacă se repară sau e nevoie de parbriz nou.',
    'ctaLabel' => 'Cere ofertă',
])

@push('head')
@php
    $graph = [
        [
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => $post->meta_description ?: $post->excerpt,
            'datePublished' => optional($post->published_at)->toAtomString(),
            'dateModified' => $post->updated_at?->toAtomString(),
            'author' => ['@type' => 'Organization', 'name' => $post->author ?: 'Echipa Înlocuire Parbriz'],
            'publisher' => ['@id' => url('/').'#organization'],
            'mainEntityOfPage' => $post->url(),
            'inLanguage' => 'ro-RO',
        ],
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Acasă', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => route('blog.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $post->title, 'item' => $post->url()],
            ],
        ],
    ];
    if ($faq) {
        $graph[] = [
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($i) => ['@type' => 'Question', 'name' => $i['q'] ?? '', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $i['a'] ?? '']], $faq),
        ];
    }
@endphp
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
@endsection
