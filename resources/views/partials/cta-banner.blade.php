@php
    $ctaTitle = $ctaTitle ?? 'Ai parbrizul spart? Solicită o ofertă.';
    $ctaText = $ctaText ?? 'Trimite marca, modelul și anul mașinii. Dacă poți, atașează și o fotografie cu avaria.';
    $ctaHref = $ctaHref ?? route('lead.create');
    $ctaLabel = $ctaLabel ?? 'Solicită ofertă';
@endphp
<section class="ee-cta">
    <div class="container ee-cta__inner">
        <div>
            <h2 class="ee-cta__title">{{ $ctaTitle }}</h2>
            <p class="ee-cta__text">{{ $ctaText }}</p>
        </div>
        <a href="{{ $ctaHref }}" class="ee-btn ee-btn--amber ee-btn--lg">{{ $ctaLabel }} @include('partials.icon', ['name' => 'arrow', 'size' => 20])</a>
    </div>
</section>
