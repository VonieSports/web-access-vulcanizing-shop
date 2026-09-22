<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $location = '';

    public function mount(): void
    {
        $user = Auth::user();

        $this->name = $user?->name ?? 'Super Admin';
        $this->email = $user?->email ?? 'admin@vulcanizepro.com';
        $this->phone = $user?->phone ?? '';
        $this->location = $user?->address ?? 'Metro District HQ';
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:11' ,'min:11'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->address = $this->location;
        $user->save();

        session()->flash('status', 'Profile updated successfully.');
        $this->redirectRoute('admin.profile', navigate: true);
    }
};