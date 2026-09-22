<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $errorMessage = '';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string',
        ];
    }

    protected array $messages = [
        'name.required' => 'Full name is required.',
        'name.min' => 'Name must be at least 2 characters.',
        'email.required' => 'Email address is required.',
        'email.email' => 'Enter a valid email address.',
        'email.unique' => 'This email is already registered.',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 8 characters.',
        'password.confirmed' => 'Passwords do not match.',
        'password_confirmation.required' => 'Please confirm your password.',
    ];

    public function updated($field): void
    {
        $this->validateOnly($field);
        $this->errorMessage = '';
    }

    public function register()
    {
        $this->validate();
        $this->errorMessage = '';

        try {
            DB::transaction(function () {
                $user = User::create([
                    'name' => trim(strip_tags($this->name)),
                    'email' => strtolower(trim($this->email)),
                    'password' => Hash::make($this->password),
                    'is_active' => true,
                ]);

                Log::info('Customer user created: ' . $user->id);

                $user->assignRole('customer');

                Log::info('Customer role assigned to user: ' . $user->id);

                Auth::login($user);
                session()->regenerate();
            });

            return redirect()->route('customer.dashboard')->with('success', 'Account created successfully!');
        } catch (\Exception $e) {
            $this->errorMessage = 'Registration failed: ' . $e->getMessage();
            Log::error('Customer registration error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}; ?>


