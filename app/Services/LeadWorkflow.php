<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\LeadAssignment;
use App\Models\LeadEvent;
use App\Models\LeadNote;
use App\Models\Provider;
use App\Services\Notifications\LeadNotifier;
use Illuminate\Support\Facades\DB;

/**
 * Operații de workflow pentru lead-uri, folosite din panourile Filament.
 * Păstrează istoricul în lead_assignments / lead_events / lead_notes.
 */
class LeadWorkflow
{
    public function assign(Lead $lead, ?int $providerId, ?int $byUserId): void
    {
        DB::transaction(function () use ($lead, $providerId, $byUserId) {
            $lead->assigned_provider_id = $providerId;

            if ($providerId && in_array($lead->status, ['noua', 'in_analiza'], true)) {
                $lead->status = 'atribuita';
            }

            $lead->save();

            if ($providerId) {
                LeadAssignment::query()->create([
                    'lead_id' => $lead->id,
                    'provider_id' => $providerId,
                    'assigned_by' => $byUserId,
                    'status' => 'assigned',
                    'assigned_at' => now(),
                ]);
            }

            LeadEvent::query()->create([
                'lead_id' => $lead->id,
                'user_id' => $byUserId,
                'type' => $providerId ? 'assigned' : 'unassigned',
                'payload' => ['provider_id' => $providerId],
            ]);
        });

        if ($providerId) {
            $provider = Provider::query()->find($providerId);
            if ($provider) {
                rescue(fn () => app(LeadNotifier::class)->notifyAssigned($lead->fresh(), $provider), report: true);
            }
        }
    }

    public function changeStatus(Lead $lead, string $status, ?int $byUserId, ?string $note = null): void
    {
        $old = $lead->status;
        DB::transaction(function () use ($lead, $status, $byUserId, $note, $old) {
            $lead->status = $status;
            $lead->save();

            LeadEvent::query()->create([
                'lead_id' => $lead->id,
                'user_id' => $byUserId,
                'type' => 'status_changed',
                'payload' => ['from' => $old, 'to' => $status],
            ]);

            if (filled($note)) {
                LeadNote::query()->create([
                    'lead_id' => $lead->id,
                    'user_id' => $byUserId,
                    'body' => $note,
                ]);
            }
        });

        rescue(fn () => app(LeadNotifier::class)->notifyStatusChanged($lead->fresh(), $old, $status, $byUserId ? \App\Models\User::query()->find($byUserId) : null), report: true);
    }
}
