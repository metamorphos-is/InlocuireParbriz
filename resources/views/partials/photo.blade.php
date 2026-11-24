{{-- Fotografie optimizată: 720px pe mobil, 1280px pe desktop, lazy (în afară de hero). --}}
@php
    $img = \App\Support\Img::get($slug ?? null);
    $eager = $eager ?? false;
@endphp
@if ($img)
    <figure class="ip-photo {{ $class ?? '' }}">
        <img src="{{ $img['src720'] }}"
             srcset="{{ $img['src720'] }} 720w, {{ $img['src'] }} 1280w"
             sizes="{{ $sizes ?? '(min-width: 992px) 50vw, 100vw' }}"
             width="{{ $img['w'] }}" height="{{ $img['h'] }}"
             alt="{{ $alt ?? $img['alt'] }}"
             @if ($eager) fetchpriority="high" @else loading="lazy" @endif
             decoding="async">
        @if (! empty($caption))<figcaption>{{ $caption }}</figcaption>@endif
        {{ $slot ?? '' }}
    </figure>
@endif
