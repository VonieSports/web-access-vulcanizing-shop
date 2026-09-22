
<div class="min-h-screen bg-slate-100">
    <div class="mx-auto flex min-h-screen max-w-7xl items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid w-full overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-[0_30px_80px_rgba(15,23,42,0.08)] lg:grid-cols-[1.15fr_0.85fr]">
            <div class="relative hidden flex-col justify-between bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 p-8 text-white lg:flex">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-3 py-1.5 text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-200">
                        Shop owner access
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="text-4xl font-black tracking-tight">Sell smarter. Serve faster.</div>
                    <p class="max-w-md text-sm leading-7 text-slate-300">
                        Manage your inventory, products, orders, and storefront with a clean, focused owner dashboard built for everyday operations.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-sm">
                    <div class="flex items-center justify-between text-xs uppercase tracking-[0.2em] text-slate-300">
                        <span>Business status</span>
                        <span class="rounded-full bg-emerald-400/20 px-2 py-1 text-[10px] font-semibold text-emerald-300">Online</span>
                    </div>
                    <div class="mt-4 flex items-end gap-3">
                        <div class="text-3xl font-bold text-white">24K</div>
                        <div class="pb-1 text-sm text-slate-300">monthly sales</div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center bg-white p-6 sm:p-10">
                <div class="w-full max-w-md">
                    <div class="mb-8 text-center lg:text-left">
                        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-900 text-lg font-black text-white shadow-sm lg:mx-0">
                            VS
                        </div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-slate-500">Welcome back</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Owner login</h1>
                    </div>

                    <form wire:submit="login" class="space-y-5">
                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email address</label>
                            <input
                                id="email"
                                wire:model.defer="email"
                                type="email"
                                autocomplete="email"
                                placeholder="you@shop.com"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:bg-white focus:ring-4 focus:ring-slate-100"
                            >
                            @error('email')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                            <input
                                id="password"
                                wire:model.defer="password"
                                type="password"
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:bg-white focus:ring-4 focus:ring-slate-100"
                            >
                            @error('password')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-900 px-4 py-3.5 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-70"
                        >
                            <span wire:loading.remove>Sign in</span>
                            <span wire:loading>Signing in...</span>
                        </button>
                    </form>

                    <p class="mt-6 text-center text-sm text-slate-500">
                        Need help? <a href="{{ route('index.page') }}" class="font-semibold text-slate-700 hover:text-slate-900">Go back home</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>