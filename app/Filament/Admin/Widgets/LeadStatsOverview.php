<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Lead;
use App\Support\LeadStatus;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeadStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $new = Lead::query()->where('status', 'noua')->count();

        $urgent = Lead::query()
            ->where('urgency', true)
            ->whereIn('status', LeadStatus::OPEN)
            ->count();

        $unassigned = Lead::query()
            ->whereNull('assigned_provider_id')
            ->whereIn('status', LeadStatus::OPEN)
            ->count();

        return [
            Stat::make('Lead-uri noi', $new)
                ->description('Status „Nouă”')
                ->color($new > 0 ? 'danger' : 'success'),
            Stat::make('Urgente', $urgent)
                ->description('Urgente încă deschise')
                ->color($urgent > 0 ? 'danger' : 'success'),
            Stat::make('Neatribuite', $unassigned)
                ->description('Fără prestator')
                ->color($unassigned > 0 ? 'warning' : 'success'),
        ];
    }
}
