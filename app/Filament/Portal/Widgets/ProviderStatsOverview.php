<?php

namespace App\Filament\Portal\Widgets;

use App\Models\Lead;
use App\Support\LeadStatus;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProviderStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $providerId = auth()->user()?->provider?->id ?? 0;
        $base = fn () => Lead::query()->where('assigned_provider_id', $providerId);

        $received = $base()->whereIn('status', LeadStatus::PROVIDER_RECEIVED)->count();
        $inProgress = $base()->whereIn('status', LeadStatus::PROVIDER_IN_PROGRESS)->count();
        $completed = $base()->where('status', 'finalizata')->count();
        $earned = (float) $base()->where('status', 'finalizata')->sum('agreed_amount');

        return [
            Stat::make('Primite', $received)->description('Așteaptă preluarea')->color($received > 0 ? 'warning' : 'success'),
            Stat::make('În lucru', $inProgress)->color('info'),
            Stat::make('Finalizate', $completed)->color('success'),
            Stat::make('Total agreat (finalizate)', number_format($earned, 2, ',', '.').' RON')->color('success'),
        ];
    }
}
