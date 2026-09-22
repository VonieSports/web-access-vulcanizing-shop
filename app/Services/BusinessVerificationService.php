<?php

namespace App\Services;

use App\Enums\VerificationStatus;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Str;

class BusinessVerificationService
{
    public function statusLabel(?Tenant $tenant): string
    {
        if (! $tenant) {
            return 'No business profile';
        }

        return match ($tenant->verification_status ?? VerificationStatus::Pending->value) {
            VerificationStatus::Approved->value => 'Approved',
            VerificationStatus::Rejected->value => 'Rejected',
            VerificationStatus::Suspended->value => 'Suspended',
            default => 'Pending review',
        };
    }

    public function canAccessOwnerPortal(?Tenant $tenant): bool
    {
        return $tenant
            && $tenant->business_setup_completed
            && $tenant->verification_status === VerificationStatus::Approved->value
            && (bool) $tenant->is_active;
    }

    public function createOrUpdateBusiness(User $user, array $payload): Tenant
    {
        $tenant = $user->tenant;

        if ($tenant) {
            $tenant->fill($payload);
            $tenant->save();

            return $tenant;
        }

        return Tenant::create($payload);
    }

    public function approve(Tenant $tenant): void
    {
        $tenant->update([
            'verification_status' => VerificationStatus::Approved->value,
            'rejection_reason' => null,
            'missing_requirements' => null,
            'is_active' => true,
            'business_setup_completed' => true,
        ]);
    }

    public function reject(Tenant $tenant, string $reason = ''): void
    {
        $tenant->update([
            'verification_status' => VerificationStatus::Rejected->value,
            'rejection_reason' => $reason !== '' ? $reason : 'Your business submission did not meet the required verification criteria.',
            'missing_requirements' => $reason !== '' ? [$reason] : ['Business verification details were incomplete or did not meet platform standards.'],
            'is_active' => false,
            'business_setup_completed' => true,
        ]);
    }

    public function buildSubmissionPayload(User $user, array $data, array $permitPaths = []): array
    {
        return [
            'user_id' => $user->id,
            'name' => trim(strip_tags((string) ($data['shop_name'] ?? ''))),
            'slug' => Str::slug(trim((string) ($data['shop_name'] ?? ''))) ?: 'shop-owner-business',
            'phone' => trim(strip_tags((string) ($data['phone'] ?? ''))),
            'email' => strtolower(trim((string) ($data['shop_email'] ?? ''))),
            'address' => trim(strip_tags((string) ($data['address'] ?? ''))),
            'business_hours' => ! empty($data['business_hours']) ? (is_array($data['business_hours']) ? $data['business_hours'] : json_decode((string) $data['business_hours'], true) ?? $data['business_hours']) : null,
            'attachment' => ! empty($permitPaths) ? $permitPaths : null,
            'business_setup_completed' => true,
            'verification_status' => VerificationStatus::Pending->value,
            'rejection_reason' => null,
            'missing_requirements' => null,
            'submitted_at' => now(),
            'is_active' => false,
        ];
    }
}
