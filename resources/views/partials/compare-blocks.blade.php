@php
    $leftTitle = $leftTitle ?? 'Reparație';
    $rightTitle = $rightTitle ?? 'Înlocuire';
    $leftItems = $leftItems ?? [];
    $rightItems = $rightItems ?? [];
@endphp
<div class="ee-compare">
    <div class="ee-compare__col">
        <h3 class="ee-compare__title">{{ $leftTitle }}</h3>
        <ul>
            @foreach ($leftItems as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>
    <div class="ee-compare__col ee-compare__col--accent">
        <h3 class="ee-compare__title">{{ $rightTitle }}</h3>
        <ul>
            @foreach ($rightItems as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>
</div>
