<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;

new class extends Component
{
    public string $email = '';
    public string $password = '';

    protected array $rules = [
        'email' => ['required', 'email', 'max:255'],
        'password' => ['required', 'string', 'min:8'],
    ];

    protected array $messages = [
        'email.required' => 'Email is required.',
        'email.email' => 'Please provide a valid email address.',
        'email.max' => 'Email must not exceed 255 characters.',
        'password.required' => 'Password is required.',
        'password.string' => 'Password format is invalid.',
        'password.min' => 'Password must be at least 8 characters long.',
    ];

    public function login(): void
    {
        $this->email = trim(Str::lower($this->email));
        $this->password = trim($this->password);

        $this->validate();

        $key = 'owner_login|' . $this->email . '|' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('email', "Too many attempts. Please try again in {$seconds} seconds.");
            return;
        }

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            RateLimiter::hit($key, 60);
            $this->addError('email', 'Invalid email or password.');
            return;
        }

        $user = Auth::user();

        if (! $user || ! $user->hasRole('owner')) {
            Auth::logout();
            RateLimiter::hit($key, 60);
            $this->addError('email', 'This account is not authorized for shop owner access.');
            return;
        }

        RateLimiter::clear($key);
        request()->session()->regenerate();

        $this->redirect(route('owner.dashboard'), navigate: true);
    }
};