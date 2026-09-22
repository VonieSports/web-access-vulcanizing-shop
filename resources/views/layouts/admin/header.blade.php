<div class="sticky top-0 z-20 border-b border-slate-200 bg-white/90 backdrop-blur supports-[backdrop-filter]:bg-white/80">
    <div class="flex h-20 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <button
                id="adminSidebarToggle"
                type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 lg:hidden"
                aria-label="Toggle sidebar"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-900 text-sm font-bold text-white shadow-sm">
                    VS
                </div>
                <div class="hidden sm:block">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-500">Operations</p>
                    <h1 class="text-sm font-semibold text-slate-900">Vulcanizing Shop</h1>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 md:flex">
                <span class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span>
                <span class="text-xs font-semibold text-emerald-700">System online</span>
            </div>

            <div class="flex items-center gap-3 rounded-full border border-slate-200 bg-white px-2 py-1.5 shadow-sm">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-slate-900 via-slate-700 to-orange-500 text-xs font-bold text-white">
                    SA
                </div>
                <div class="hidden sm:block text-left">
                    <p class="text-sm font-semibold text-slate-900">Super Admin</p>
                    <p class="text-[11px] text-slate-500">Platform admin</p>
                </div>
            </div>
        </div>
    </div>
</div>
