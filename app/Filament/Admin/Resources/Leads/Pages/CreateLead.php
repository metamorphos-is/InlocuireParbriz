<?php

namespace App\Filament\Admin\Resources\Leads\Pages;

use App\Filament\Admin\Resources\Leads\LeadResource;
use App\Models\LeadEvent;
use Filament\Resources\Pages\CreateRecord;

class CreateLead extends CreateRecord
{
    protected static string $resource = LeadResource::class;

    protected function afterCreate(): void
    {
        LeadEvent::query()->create([
            'lead_id' => $this->record->id,
            'user_id' => auth()->id(),
            'type' => 'created_manually',
            'payload' => null,
        ]);
    }
}
