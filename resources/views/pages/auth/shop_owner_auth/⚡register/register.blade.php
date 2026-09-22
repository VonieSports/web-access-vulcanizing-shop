<div class="min-h-screen bg-slate-100">
    <div class="mx-auto flex min-h-screen max-w-7xl items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid w-full overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-[0_30px_80px_rgba(15,23,42,0.08)] lg:grid-cols-[1.05fr_0.95fr]">
            <div class="relative hidden flex-col justify-between bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 p-8 text-white lg:flex">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-3 py-1.5 text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-200">
                        Start your shop
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="text-4xl font-black tracking-tight">Open your business profile.</div>
                    <p class="max-w-md text-sm leading-7 text-slate-300">
                        Create your store account, send your business details for review, and access your dashboard only after approval.
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-center bg-white p-6 sm:p-10">
                <div class="w-full max-w-xl">
                    <div class="mb-8 text-center lg:text-left">
                        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-900 text-lg font-black text-white shadow-sm lg:mx-0">
                            VS
                        </div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-slate-500">Create account</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Owner registration</h1>
                    </div>

                    <form wire:submit="register" class="space-y-5">
                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Full name</label>
                                <input wire:model.defer="name" type="text" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-900 focus:bg-white focus:ring-4 focus:ring-slate-100" placeholder="Juan Dela Cruz" />
                                @error('name') <span class="mt-2 block text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                                <input wire:model.defer="email" type="email" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-900 focus:bg-white focus:ring-4 focus:ring-slate-100" placeholder="owner@shop.com" />
                                @error('email') <span class="mt-2 block text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                                <input wire:model.defer="password" type="password" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-900 focus:bg-white focus:ring-4 focus:ring-slate-100" placeholder="Minimum 8 characters" />
                                @error('password') <span class="mt-2 block text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Confirm password</label>
                                <input wire:model.defer="password_confirmation" type="password" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-900 focus:bg-white focus:ring-4 focus:ring-slate-100" placeholder="Repeat password" />
                                @error('password_confirmation') <span class="mt-2 block text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <button type="submit" wire:loading.attr="disabled" class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-900 px-4 py-3.5 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-70">
                            <span wire:loading.remove>Create owner account</span>
                            <span wire:loading>Submitting...</span>
                        </button>
                    </form>

                    <p class="mt-6 text-center text-sm text-slate-500">
                        Already have an account? <a href="{{ route('owner.login') }}" class="font-semibold text-slate-700 hover:text-slate-900">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>