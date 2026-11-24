@php
    $steps = $steps ?? [];
@endphp
<ol class="ee-steps">
    @foreach ($steps as $i => [$title, $text])
        <li class="ee-steps__item">
            <span class="ee-steps__num" aria-hidden="true">{{ $i + 1 }}</span>
            <div>
                <h3 class="ee-steps__title">{{ $title }}</h3>
                <p class="ee-steps__text">{{ $text }}</p>
            </div>
        </li>
    @endforeach
</ol>
