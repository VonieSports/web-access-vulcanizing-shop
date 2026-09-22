<header class="sticky top-0 z-20 border-b border-slate-200 bg-white/90 backdrop-blur supports-[backdrop-filter]:bg-white/80">
    <div class="flex h-20 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <button
                id="ownerSidebarToggle"
                type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 lg:hidden"
                aria-label="Toggle sidebar"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

        </div>

        <div class="flex items-center gap-3">
            <div class="flex items-center gap-3 rounded-full border border-slate-200 bg-white px-2 py-1.5 shadow-sm">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-slate-900 via-slate-700 to-slate-500 text-xs font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'SO', 0, 2)) }}
                </div>
                <div class="hidden sm:block text-left">
                    <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name ?? 'Shop owner' }}</p>
                    <p class="text-[11px] text-slate-500">Business account</p>
                </div>
            </div>
        </div>
    </div>
</header>