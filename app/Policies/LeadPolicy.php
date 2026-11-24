<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

/**
 * Super admin: acces complet. Prestator: doar lead-urile atribuite lui,
 * fără creare/ștergere.
 */
class LeadPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active && ($user->isSuperAdmin() || ($user->isProvider() && $user->provider !== null));
    }

    public function view(User $user, Lead $lead): bool
    {
        return $this->owns($user, $lead);
    }

    public function create(User $user): bool
    {
        return $user->is_active && $user->isSuperAdmin();
    }

    public function update(User $user, Lead $lead): bool
    {
        return $this->owns($user, $lead);
    }

    public function delete(User $user, Lead $lead): bool
    {
        return $user->is_active && $user->isSuperAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->is_active && $user->isSuperAdmin();
    }

    public function restore(User $user, Lead $lead): bool
    {
        return $this->delete($user, $lead);
    }

    public function forceDelete(User $user, Lead $lead): bool
    {
        return $this->delete($user, $lead);
    }

    private function owns(User $user, Lead $lead): bool
    {
        if (! $user->is_active) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->isProvider()
            && $user->provider !== null
            && $lead->assigned_provider_id === $user->provider->id;
    }
}
