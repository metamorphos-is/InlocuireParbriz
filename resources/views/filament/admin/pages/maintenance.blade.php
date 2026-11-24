<x-filament-panels::page>
    <div class="grid gap-4 md:grid-cols-2">
        <x-filament::section>
            <x-slot name="heading">Versiunea publicată</x-slot>
            <p class="text-sm">Commit: <code>{{ $head ? substr($head, 0, 10) : 'necunoscut' }}</code></p>
            @if ($lastRun)
                <p class="mt-1 text-sm">Ultimul post-deploy: {{ \Illuminate\Support\Carbon::parse($lastRun['at'])->format('d.m.Y H:i') }}
                    (<code>{{ substr((string) $lastRun['head'], 0, 10) }}</code>)</p>
            @endif
        </x-filament::section>
        <x-filament::section>
            <x-slot name="heading">Cron (rulare automată)</x-slot>
            @if ($heartbeat)
                <x-filament::badge color="success">Activ</x-filament::badge>
                <span class="text-sm">ultimul semnal {{ \Illuminate\Support\Carbon::parse($heartbeat)->diffForHumans() }}</span>
            @else
                <x-filament::badge color="warning">Inactiv</x-filament::badge>
                <p class="mt-2 text-sm text-gray-600">Migrările nu rulează singure după deploy — folosește butonul de sus.</p>
            @endif
        </x-filament::section>
    </div>
    <x-filament::section>
        <x-slot name="heading">Migrări în așteptare</x-slot>
        <pre class="overflow-x-auto whitespace-pre-wrap text-xs">{{ $pending ?: 'Nicio migrare în așteptare.' }}</pre>
    </x-filament::section>
</x-filament-panels::page>
