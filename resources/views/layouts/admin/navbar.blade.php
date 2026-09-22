<div id="adminSidebar" class="sticky top-0 inset-y-0 left-0 z-40 w-72 -translate-x-full border-r border-slate-200 bg-white shadow-xl transition-transform duration-200 lg:static lg:w-72 lg:translate-x-0 lg:shadow-none">
    <div class="flex h-full flex-col">
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-900 text-sm font-bold text-white">VS</div>
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-500">Admin</p>
                    <h2 class="text-sm font-semibold text-slate-900">Control panel</h2>
                </div>
            </div>

            <button
                id="adminSidebarClose"
                type="button"
                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:bg-slate-50 lg:hidden"
                aria-label="Close sidebar"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="flex-1 space-y-2 overflow-y-auto px-4 py-5">
            <div class="mb-4 px-2">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Overview</p>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 rounded-xl border border-orange-200 bg-orange-50 px-3 py-2.5 text-sm font-semibold text-orange-700 shadow-sm">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-orange-100 text-orange-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 11.5L12 4l9 7.5V20a1 1 0 01-1 1h-5v-7H9v7H4a1 1 0 01-1-1v-8.5z" />
                    </svg>
                </span>
                Dashboard
            </a>

            <a href="{{ route('admin.profile') }}" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-600 group-hover:bg-slate-200 group-hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 19v-1a4 4 0 00-4-4H8a4 4 0 00-4 4v1M12 11a4 4 0 100-8 4 4 0 000 8z" />
                    </svg>
                </span>
                Profile
            </a>

            <a href="{{ route('admin.update_profile') }}" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-600 group-hover:bg-slate-200 group-hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5h9M11 12h9M11 19h9M3 4h.01M3 11h.01M3 18h.01" />
                    </svg>
                </span>
                Update profile
            </a>

            <div class="my-4 border-t border-slate-200"></div>

            <div class="mb-2 px-2">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Management</p>
            </div>

            <a href="{{ route('admin.shop_approval') }}" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-600 group-hover:bg-slate-200 group-hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12l4 4L19 2M5 22h14" />
                    </svg>
                </span>
                Shop approvals
            </a>
        </nav>

        <div class="border-t border-slate-200 p-4">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div class="mb-2 flex items-center justify-between text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">
                    <span>Platform</span>
                    <span class="rounded-full bg-emerald-100 px-2 py-1 text-[10px] font-bold text-emerald-700">Live</span>
                </div>
                <p class="text-sm font-semibold text-slate-900">24 active tenants</p>
                <p class="mt-1 text-xs text-slate-500">Updated just now</p>
            </div>
        </div>
    </div>
</div>

<div id="adminSidebarOverlay" class="fixed inset-0 z-30 hidden bg-slate-950/40 lg:hidden"></div>
