<x-filament-panels::page>
    <div class="grid gap-4 md:grid-cols-3">
        <x-filament::section>
            <x-slot name="heading">Conexiune</x-slot>
            @if ($configured)
                <p class="text-sm"><x-filament::badge color="success">Configurat</x-filament::badge></p>
                @if ($account)
                    <p class="mt-2 text-sm">Cont: <strong>{{ $account['login'] }}</strong><br>
                        Sold: <strong>{{ number_format((float) $account['balance'], 2) }} USD</strong>
                        <span class="text-gray-500">({{ $account['at'] }})</span></p>
                @endif
            @else
                <p class="text-sm"><x-filament::badge color="danger">Neconfigurat</x-filament::badge></p>
                <p class="mt-2 text-sm text-gray-600">Adaugă <code>DATAFORSEO_LOGIN</code> și <code>DATAFORSEO_PASSWORD</code> în <code>.env</code> pe server
                    sau completează secțiunea DataForSEO din <em>Setări site</em>.</p>
            @endif
        </x-filament::section>
        <x-filament::section>
            <x-slot name="heading">Buget luna curentă</x-slot>
            <p class="text-2xl font-semibold">{{ number_format($spent, 2) }} / {{ number_format($budget, 2) }} USD</p>
            <p class="mt-1 text-sm text-gray-500">Peste plafon, apelurile noi sunt refuzate. Răspunsurile identice din ultimele 30 de zile sunt refolosite gratuit din cache.</p>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="heading">Rulare automată</x-slot>
            @if ($schedulerAlive)
                <p class="text-sm"><x-filament::badge color="success">Activă</x-filament::badge> ultimul semnal: {{ \Illuminate\Support\Carbon::parse($schedulerAlive)->diffForHumans() }}</p>
            @else
                <p class="text-sm"><x-filament::badge color="warning">Cron inactiv</x-filament::badge></p>
                <p class="mt-2 text-sm text-gray-600">Cercetările din coadă nu pornesc singure. Folosește „Rulează acum” din tabel.</p>
            @endif
        </x-filament::section>
    </div>

    {{ $this->table }}
</x-filament-panels::page>
