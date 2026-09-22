<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ];
    }

    protected array $messages = [
        'name.required' => 'Full name is required.',
        'email.required' => 'Email address is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered.',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 8 characters long.',
        'password.confirmed' => 'Passwords do not match.',
    ];

    public function register(): void
    {
        $this->validate();

        $user = User::create([
            'name' => trim(strip_tags($this->name)),
            'email' => strtolower(trim($this->email)),
            'password' => Hash::make($this->password),
            'is_active' => true,
        ]);

        Role::firstOrCreate(['name' => 'owner', 'guard_name' => 'web']);
        $user->assignRole('owner');

        Auth::login($user);
        session()->regenerate();

        $this->redirectRoute('owner.business_setup', navigate: true);
    }
};