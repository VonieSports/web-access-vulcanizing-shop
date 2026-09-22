<?php

use App\Enums\VerificationStatus;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

new #[Layout('layouts.shop_owner')] class extends Component
{
    use WithFileUploads;

    public string $shop_name = '';
    public string $shop_email = '';
    public string $phone = '';
    public string $address = '';
    public $logo;
    public array $business_hours = [];
    public array $permit_documents = [];
    public bool $business_setup_completed = false;

    public array $dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    public array $timeOptions = [];

    public function mount(): void
    {
        $this->timeOptions = $this->generateTimeOptions();

        $tenant = Auth::user()?->tenant;

        if ($tenant) {
            $this->shop_name = (string) ($tenant->name ?? '');
            $this->shop_email = (string) ($tenant->email ?? '');
            $this->phone = (string) ($tenant->phone ?? '');
            $this->address = (string) ($tenant->address ?? '');
            $this->business_hours = is_array($tenant->business_hours) ? $tenant->business_hours : $this->defaultBusinessHours();
            $this->business_setup_completed = (bool) $tenant->business_setup_completed;
        } else {
            $this->shop_email = (string) (Auth::user()?->email ?? '');
            $this->business_hours = $this->defaultBusinessHours();
        }
    }

    public function save(): void
    {
        $user = Auth::user();

        if (! $user) {
            abort(403, 'Unauthorized');
        }

        $this->validate([
            'shop_name' => ['required', 'string', 'min:2', 'max:255'],
            'shop_email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'min:7', 'max:30'],
            'address' => ['required', 'string', 'min:10', 'max:500'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'business_hours' => ['nullable', 'array'],
            'business_hours.*.open' => ['nullable', 'string'],
            'business_hours.*.close' => ['nullable', 'string'],
            'permit_documents' => ['nullable', 'array'],
            'permit_documents.*' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:4048'],
        ]);

        $tenant = $user->tenant;
        $paths = [];

        foreach ($this->permit_documents as $file) {
            if ($file) {
                $paths[] = $file->store('tenant-documents', 'public');
            }
        }

        $logoPath = null;
        if ($this->logo) {
            $logoPath = $this->logo->store('tenant-logos', 'public');
        }

        $payload = [
            'user_id' => $user->id,
            'name' => trim(strip_tags($this->shop_name)),
            'slug' => Str::slug(trim($this->shop_name)) ?: 'shop-owner-business',
            'phone' => trim(strip_tags($this->phone)),
            'email' => strtolower(trim($this->shop_email)),
            'address' => trim(strip_tags($this->address)),
            'logo' => $logoPath ?? ($tenant?->logo ?? null),
            'business_hours' => $this->normalizeBusinessHours($this->business_hours),
            'attachment' => ! empty($paths) ? $paths : ($tenant?->attachment ?? null),
            'business_setup_completed' => true,
            'verification_status' => VerificationStatus::Pending->value,
            'rejection_reason' => null,
            'missing_requirements' => null,
            'submitted_at' => now(),
            'is_active' => false,
        ];

        if ($tenant) {
            $tenant->fill($payload);
            $tenant->save();
        } else {
            Tenant::create($payload);
        }

        session()->flash('success', 'Business profile submitted for review. Your application is pending admin approval.');
        $this->redirectRoute('owner.business_status', navigate: true);
    }

    protected function defaultBusinessHours(): array
    {
        return array_fill_keys($this->dayNames, ['open' => '09:00', 'close' => '18:00']);
    }

    protected function normalizeBusinessHours(array $hours): array
    {
        $normalized = [];

        foreach ($this->dayNames as $day) {
            $entry = $hours[$day] ?? ['open' => '09:00', 'close' => '18:00'];
            $normalized[$day] = [
                'open' => (string) ($entry['open'] ?? '09:00'),
                'close' => (string) ($entry['close'] ?? '18:00'),
            ];
        }

        return $normalized;
    }

    protected function generateTimeOptions(): array
    {
        $slots = [];
        $start = strtotime('00:00');

        for ($i = 0; $i < 48; $i++) {
            $time = date('H:i', $start + ($i * 30 * 60));
            $slots[$time] = $time;
        }

        return $slots;
    }
};
