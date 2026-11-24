<article class="ee-card">
    <span class="ee-card__icon">@include('partials.icon', ['name' => $s['icon'], 'size' => 28])</span>
    <h3 class="ee-card__title"><a href="{{ route('bucuresti.show', $slug) }}">{{ $s['name'] }}</a></h3>
    <p class="ee-card__text">{{ $s['short'] }}</p>
    <div class="ee-card__links">
        <a href="{{ route('bucuresti.show', $slug) }}" class="ee-link">În București @include('partials.icon', ['name' => 'arrow', 'size' => 16])</a>
        <a href="{{ route('lead.create', ['serviciu' => $slug]) }}" class="ee-link ee-link--amber">Solicită ofertă</a>
    </div>
</article>
