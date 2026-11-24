<?php

namespace App\Filament\Portal\Resources\Leads\Pages;

use App\Filament\Portal\Resources\Leads\LeadResource;
use App\Support\LeadStatus;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected ?string $heading = 'Lead-urile mele';

    public function getTabs(): array
    {
        return [
            'primite' => Tab::make('Primite')
                ->icon('heroicon-o-inbox-arrow-down')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('status', LeadStatus::PROVIDER_RECEIVED)),
            'in_lucru' => Tab::make('În lucru')
                ->icon('heroicon-o-wrench-screwdriver')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('status', LeadStatus::PROVIDER_IN_PROGRESS)),
            'finalizate' => Tab::make('Finalizate')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('status', LeadStatus::PROVIDER_COMPLETED)),
            'toate' => Tab::make('Toate'),
        ];
    }
}
