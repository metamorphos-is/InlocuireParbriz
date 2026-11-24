<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div>
            <x-filament::button type="submit">
                Salvează setările
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
