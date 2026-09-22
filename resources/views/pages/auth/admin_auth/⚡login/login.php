<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;

new class extends Component
{
    public string $email = '';
    public string $password = '';

    public function login(): void
    {
        $this->email = trim(Str::lower($this->email));

        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $key = 'sa|' . $this->email . '|' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('email', "Too many attempts. Try again in {$seconds} seconds.");
            return;
        }

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            RateLimiter::hit($key, 60);
            $this->addError('email', 'These credentials do not match our records.');
            return;
        }

        $user = Auth::user();

        if (! $user->hasRole('admin')) {
            Auth::logout();
            RateLimiter::hit($key, 60);
            $this->addError('email', 'This account is not authorized.');
            return;
        }

        RateLimiter::clear($key);
        request()->session()->regenerate();

        $this->redirectRoute('admin.dashboard', navigate: true);
    }
}; ?>
