<?php

use App\Enums\VerificationStatus;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.shop_owner')] class extends Component
{
    public ?string $status = null;
    public ?string $rejectionReason = null;
    public ?array $missingRequirements = null;
    public bool $canSubmitAgain = false;

    public function mount(): void
    {
        $tenant = Auth::user()?->tenant;

        $this->status = $tenant?->verification_status ?? VerificationStatus::Pending->value;
        $this->rejectionReason = $tenant?->rejection_reason ?? null;
        $this->missingRequirements = $tenant?->missing_requirements ? json_decode($tenant->missing_requirements, true) : null;
        $this->canSubmitAgain = $tenant?->verification_status === VerificationStatus::Rejected->value;
    }

    public function retrySubmission(): void
    {
        $tenant = Auth::user()?->tenant;

        if (! $tenant) {
            $this->redirectRoute('owner.business_setup', navigate: true);
            return;
        }

        $tenant->update([
            'verification_status' => VerificationStatus::Pending->value,
            'rejection_reason' => null,
            'missing_requirements' => null,
            'submitted_at' => now(),
            'business_setup_completed' => true,
            'is_active' => false,
        ]);

        session()->flash('success', 'Your business profile has been resubmitted for review.');
        $this->redirectRoute('owner.business_setup', navigate: true);
    }
};;
