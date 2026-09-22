<?php

namespace App\Traits;

use App\Enums\VerificationStatus;
use App\Models\Tenant;

trait RequireTenant
{
    protected function tenantStatusLabel(?Tenant $tenant): string
    {
        if (! $tenant) {
            return 'No business profile yet';
        }

        return match ($tenant->verification_status ?? VerificationStatus::Pending->value) {
            VerificationStatus::Approved->value => 'Approved',
            VerificationStatus::Rejected->value => 'Rejected',
            VerificationStatus::Suspended->value => 'Suspended',
            default => 'Pending review',
        };
    }

    protected function canAccessStorefront(?Tenant $tenant): bool
    {
        return $tenant
            && $tenant->business_setup_completed
            && $tenant->verification_status === VerificationStatus::Approved->value
            && (bool) $tenant->is_active;
    }
}
