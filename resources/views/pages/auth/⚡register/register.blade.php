<div class="flex min-h-screen items-center justify-center bg-gray-50 px-4 py-12">
    <div class="w-full max-w-md space-y-8">
        
        <!-- Logo & Title -->
        <div class="text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-[#FF5E14] mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" stroke-width="2.5"/>
                    <circle cx="12" cy="12" r="3" stroke-width="2"/>
                    <path stroke-linecap="round" d="M12 3v3m0 12v3M3 12h3m12 0h3"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Create your account</h2>
            <p class="mt-2 text-sm text-gray-500">Join us today! Fill in your details below.</p>
        </div>

        <!-- Error Message -->
        @if ($errorMessage)
            <div class="rounded-lg bg-red-50 border border-red-100 p-3 text-sm text-red-700">
                {{ $errorMessage }}
            </div>
        @endif

        <form wire:submit="register" class="space-y-5 rounded-xl bg-white p-8 shadow-sm border border-gray-100">
            
            <!-- Full Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full name</label>
                <input wire:model.live="name" id="name" type="text" autocomplete="name" placeholder="Juan Dela Cruz"
                    class="block w-full rounded-md border-gray-300 shadow-sm placeholder-gray-400 focus:border-[#FF5E14] focus:ring-1 focus:ring-[#FF5E14] outline-none py-2.5 px-3.5 text-sm text-gray-900 transition">
                @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email address</label>
                <input wire:model.live="email" id="email" type="email" autocomplete="email" placeholder="example@gmail.com"
                    class="block w-full rounded-md border-gray-300 shadow-sm placeholder-gray-400 focus:border-[#FF5E14] focus:ring-1 focus:ring-[#FF5E14] outline-none py-2.5 px-3.5 text-sm text-gray-900 transition">
                @error('email') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <input wire:model.live="password" id="password" type="password" autocomplete="new-password" placeholder="••••••••"
                    class="block w-full rounded-md border-gray-300 shadow-sm placeholder-gray-400 focus:border-[#FF5E14] focus:ring-1 focus:ring-[#FF5E14] outline-none py-2.5 px-3.5 text-sm text-gray-900 transition">
                @error('password') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm password</label>
                <input wire:model.live="password_confirmation" id="password_confirmation" type="password" autocomplete="new-password" placeholder="••••••••"
                    class="block w-full rounded-md border-gray-300 shadow-sm placeholder-gray-400 focus:border-[#FF5E14] focus:ring-1 focus:ring-[#FF5E14] outline-none py-2.5 px-3.5 text-sm text-gray-900 transition">
            </div>

            <!-- Submit Button -->
            <button type="submit" wire:loading.attr="disabled" wire:target="register"
                class="flex w-full justify-center rounded-md bg-[#FF5E14] px-3 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#D94E10] disabled:opacity-50 transition">
                <span wire:loading.remove wire:target="register">Create account</span>
                <span wire:loading wire:target="register" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Creating account…
                </span>
            </button>

            <!-- Sign In Link -->
            <p class="text-center text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" wire:navigate class="font-medium text-[#FF5E14] hover:text-[#D94E10] transition">Sign in</a>
            </p>
        </form>
    </div>
</div>

