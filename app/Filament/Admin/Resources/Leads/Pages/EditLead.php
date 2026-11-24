<?php

namespace App\Filament\Admin\Resources\Leads\Pages;

use App\Filament\Admin\Resources\Leads\LeadResource;
use App\Models\LeadAssignment;
use App\Models\LeadEvent;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLead extends EditRecord
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->label('Șterge'),
        ];
    }

    protected function afterSave(): void
    {
        $lead = $this->record;

        if ($lead->wasChanged('assigned_provider_id')) {
            if ($lead->assigned_provider_id) {
                LeadAssignment::query()->create([
                    'lead_id' => $lead->id,
                    'provider_id' => $lead->assigned_provider_id,
                    'assigned_by' => auth()->id(),
                    'status' => 'assigned',
                    'assigned_at' => now(),
                ]);
            }

            LeadEvent::query()->create([
                'lead_id' => $lead->id,
                'user_id' => auth()->id(),
                'type' => $lead->assigned_provider_id ? 'assigned' : 'unassigned',
                'payload' => ['provider_id' => $lead->assigned_provider_id],
            ]);
        }

        if ($lead->wasChanged('status')) {
            LeadEvent::query()->create([
                'lead_id' => $lead->id,
                'user_id' => auth()->id(),
                'type' => 'status_changed',
                'payload' => ['from' => $lead->getPrevious()['status'] ?? null, 'to' => $lead->status],
            ]);
        }

        // Notificări (SMS + email) — aceleași ca în fluxul de atribuire / schimbare status.
        $notifier = app(\App\Services\Notifications\LeadNotifier::class);
        if ($lead->wasChanged('assigned_provider_id') && $lead->assigned_provider_id && ($provider = \App\Models\Provider::query()->find($lead->assigned_provider_id))) {
            rescue(fn () => $notifier->notifyAssigned($lead->fresh(), $provider), report: true);
        }
        if ($lead->wasChanged('status')) {
            rescue(fn () => $notifier->notifyStatusChanged($lead->fresh(), $lead->getPrevious()['status'] ?? null, $lead->status, auth()->user()), report: true);
        }
    }
}
