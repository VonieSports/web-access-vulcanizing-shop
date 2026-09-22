<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public array $profile = [];

    public function mount(): void
    {
        $user = Auth::user();

        $this->profile = [
            'name' => $user?->name ?? 'Super Admin',
            'email' => $user?->email ?? 'admin@vulcanizepro.com',
            'phone' => $user?->phone ?? '+63 917 000 0000',
            'role' => 'Super Admin',
            'access' => 'Platform management, tenant approvals, and store oversight',
            'status' => 'Online',
            'location' => 'Metro District HQ',
        ];
    }
};