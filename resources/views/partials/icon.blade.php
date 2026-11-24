@php
    $size = $size ?? 24;
    $paths = [
        'bolt' => '<path d="M13 2 4 14h7l-1 8 9-12h-7l1-8Z"/>',
        'wrench' => '<path d="M14.7 6.3a4 4 0 0 0 5 5L21 12.6a1 1 0 0 1 0 1.4l-7 7a1 1 0 0 1-1.4 0l-9.6-9.6a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.4 0l2.3 2.3Z"/><path d="m9 12 3 3"/>',
        'snow' => '<path d="M12 2v20M4.9 7l14.2 10M4.9 17 19.1 7"/><path d="m9 3.5 3 2.5 3-2.5M9 20.5l3-2.5 3 2.5"/>',
        'flame' => '<path d="M12 22c4 0 7-2.8 7-6.8 0-3-1.8-5-3.5-6.7-.6 1.2-1.4 2-2.5 2.5C13.5 7.5 12.5 4.5 10 2c0 4-5 6.2-5 12 0 4.4 3 8 7 8Z"/>',
        'brush' => '<path d="M3 4h14v5H3z"/><path d="M17 6.5h3V13H11v3"/><path d="M9 16h4v6H9z"/>',
        'panel' => '<rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h3M8 11h3M8 15h3M14 7h2M14 11h2M14 15h2"/>',
        'phone' => '<path d="M5 3h4l2 5-2.5 1.5a11 11 0 0 0 6 6L16 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 5a2 2 0 0 1 2-2Z"/>',
        'check' => '<path d="m5 12.5 4.5 4.5L19 7"/>',
        'arrow' => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'shield' => '<path d="M12 3 4 6v6c0 4.5 3.2 8 8 9 4.8-1 8-4.5 8-9V6l-8-3Z"/><path d="m9 12 2 2 4-4"/>',
        'pin' => '<path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.5"/>',
        'form' => '<path d="M6 3h9l4 4v14H6z"/><path d="M9 12h7M9 16h7M9 8h3"/>',
        'users' => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c.5-3.5 3-5.5 6.5-5.5s6 2 6.5 5.5"/><path d="M16 4.5a3.5 3.5 0 0 1 0 7M18 14.8c1.8.7 3 2.5 3.4 5.2"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/>',
    ];
@endphp
<svg class="ee-icon" width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">{!! $paths[$name] ?? '' !!}</svg>
