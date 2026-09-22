<?php

use App\Enums\VerificationStatus;
use App\Models\Tenant;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public array $shops = [];

    public function mount(): void
    {
        $this->loadShops();
    }

    public function loadShops(): void
    {
        $this->shops = Tenant::query()
            ->with('user')
            ->orderByDesc('submitted_at')
            ->get()
            ->map(function ($tenant) {
                return [
                    'id' => $tenant->id,
                    'shop_name' => $tenant->name,
                    'owner_name' => $tenant->user?->name ?? 'N/A',
                    'owner_email' => $tenant->user?->email ?? 'N/A',
                    'status' => $tenant->verification_status ?? VerificationStatus::Pending->value,
                    'address' => $tenant->address ?? 'N/A',
                    'phone' => $tenant->phone ?? 'N/A',
                    'submitted_at' => $tenant->submitted_at ? $tenant->submitted_at->format('M d, Y') : '—',
                    'rejection_reason' => $tenant->rejection_reason,
                    'missing_requirements' => $tenant->missing_requirements ? json_decode($tenant->missing_requirements, true) : [],
                    'attachment' => $tenant->attachment ? (is_array($tenant->attachment) ? $tenant->attachment[0] : $tenant->attachment) : null,
                ];
            })
            ->toArray();
    }

    public function approve(int $tenantId): void
    {
        $tenant = Tenant::findOrFail($tenantId);

        $tenant->update([
            'verification_status' => VerificationStatus::Approved->value,
            'rejection_reason' => null,
            'missing_requirements' => null,
            'is_active' => true,
            'business_setup_completed' => true,
        ]);

        session()->flash('success', 'Shop approved successfully.');
        $this->loadShops();
    }

    public function reject(int $tenantId, string $reason = ''): void
    {
        $tenant = Tenant::findOrFail($tenantId);

        $tenant->update([
            'verification_status' => VerificationStatus::Rejected->value,
            'rejection_reason' => $reason !== '' ? $reason : 'Your business submission did not meet the required verification criteria.',
            'missing_requirements' => $reason !== '' ? [$reason] : ['Business verification details were incomplete or did not meet platform standards.'],
            'is_active' => false,
            'business_setup_completed' => true,
        ]);

        session()->flash('success', 'Shop rejected and request sent back for resubmission.');
        $this->loadShops();
    }
};