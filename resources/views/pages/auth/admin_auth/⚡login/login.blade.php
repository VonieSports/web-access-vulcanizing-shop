
<div>
    <div class="flex min-h-screen items-center justify-center bg-gray-900 px-4 py-12">
    <div class="w-full max-w-md space-y-8">
        <h2 class="text-center text-2xl font-bold tracking-tight text-white">Super Admin</h2>

        <form wire:submit="login" class="space-y-5 rounded-lg bg-white p-6 shadow">
            <div>
                <label class="block text-sm font-medium text-gray-700">Email address</label>
                <input wire:model="email" type="email" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input wire:model="password" type="password" autocomplete="current-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled" wire:target="login"
                class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 disabled:opacity-50">
                <span wire:loading.remove wire:target="login">Sign in</span>
                <span wire:loading wire:target="login">Signing in…</span>
            </button>
        </form>
    </div>
</div>
    {{-- Always remember that you are absolutely unique. Just like everyone else. - Margaret Mead --}}
</div>
