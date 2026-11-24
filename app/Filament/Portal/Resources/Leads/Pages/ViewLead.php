<?php

namespace App\Filament\Portal\Resources\Leads\Pages;

use App\Filament\Portal\Resources\Leads\LeadResource;
use Filament\Resources\Pages\ViewRecord;

class ViewLead extends ViewRecord
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LeadResource::statusAction(),
        ];
    }
}
