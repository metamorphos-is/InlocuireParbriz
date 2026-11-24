<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Canibalizare: același cuvânt-cheie pe mai multe pagini</x-slot>
        <x-slot name="description">Compară {{ $total }} cuvinte-cheie din harta paginilor fixe (config/seo-map.php), paginile de oraș și articolele de blog.</x-slot>
        @if (empty($conflicts))
            <x-filament::badge color="success">Nicio suprapunere</x-filament::badge>
            <p class="mt-2 text-sm text-gray-600">Fiecare cuvânt-cheie principal are o singură pagină țintă.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead><tr class="border-b"><th class="py-2 pe-4">Cuvânt</th><th class="py-2 pe-4">Pagini</th></tr></thead>
                    <tbody>
                        @foreach ($conflicts as $rows)
                            <tr class="border-b align-top">
                                <td class="py-2 pe-4 font-medium">{{ $rows[0]['original'] }}</td>
                                <td class="py-2 pe-4">
                                    @foreach ($rows as $r)
                                        <div>{{ $r['label'] }} — <a class="text-primary-600 underline" href="{{ url($r['url']) }}" target="_blank">{{ $r['url'] }}</a>
                                            <x-filament::badge :color="$r['role'] === 'principal' ? 'danger' : 'gray'" class="inline-flex">{{ $r['role'] }}</x-filament::badge></div>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="mt-3 text-sm text-gray-600">Rezolvare: păstrează cuvântul pe o singură pagină, iar pe celelalte alege altul și pune un link spre pagina principală.</p>
        @endif
    </x-filament::section>

    <x-filament::section>
        <x-slot name="heading">Titluri și descrieri</x-slot>
        @if (empty($issues))
            <x-filament::badge color="success">Totul în regulă</x-filament::badge>
        @else
            <ul class="space-y-1 text-sm">
                @foreach ($issues as [$label, $url, $msg])
                    <li><a class="text-primary-600 underline" href="{{ url($url) }}" target="_blank">{{ $label }}</a> — {{ $msg }}</li>
                @endforeach
            </ul>
        @endif
    </x-filament::section>

    <x-filament::section>
        <x-slot name="heading">Linkuri interne (blog → servicii)</x-slot>
        @if (empty($links))
            <x-filament::badge color="success">Toate articolele trimit spre pagina de serviciu legată</x-filament::badge>
        @else
            <ul class="space-y-1 text-sm">
                @foreach ($links as [$label, $url, $msg])
                    <li><a class="text-primary-600 underline" href="{{ url($url) }}" target="_blank">{{ $label }}</a> — {{ $msg }}</li>
                @endforeach
            </ul>
        @endif
    </x-filament::section>
</x-filament-panels::page>
