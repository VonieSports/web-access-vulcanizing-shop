@php
    $navGroups = [
        [
            'label' => 'Overview',
            'items' => [
                ['label' => 'Dashboard', 'route' => 'owner.dashboard', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 11.5L12 4l9 7.5V20a1 1 0 01-1 1h-5v-7H9v7H4a1 1 0 01-1-1v-8.5z" /></svg>'],
                ['label' => 'Profile', 'route' => 'owner.profile', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 19v-1a4 4 0 00-4-4H8a4 4 0 00-4 4v1M12 11a4 4 0 100-8 4 4 0 000 8z" /></svg>'],
                ['label' => 'Update profile', 'route' => 'owner.update_profile', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5h9M11 12h9M11 19h9M3 4h.01M3 11h.01M3 18h.01" /></svg>'],
            ],
        ],
        [
            'label' => 'Catalog',
            'items' => [
                ['label' => 'Products', 'route' => 'owner.products', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7.5L12 3l8 4.5v9L12 21l-8-4.5v-9zm8 4.5l8-4.5M12 12v9" /></svg>'],
                ['label' => 'Create product', 'route' => 'owner.product_create', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" /></svg>'],
                ['label' => 'Categories', 'route' => 'owner.categories', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7.5A2.5 2.5 0 016.5 5h4.9a2.5 2.5 0 011.77.73L14.5 7H17.5A2.5 2.5 0 0120 9.5v7A2.5 2.5 0 0117.5 19h-11A2.5 2.5 0 014 16.5v-9z" /></svg>'],
                ['label' => 'Inventory', 'route' => 'owner.inventory', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L12 3l9 4.5-9 4.5-9-4.5zm9 4.5v9m-9-4.5l9 4.5 9-4.5" /></svg>'],
            ],
        ],
        [
            'label' => 'Operations',
            'items' => [
                ['label' => 'Orders', 'route' => 'owner.order_management', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M7 12h10M8 17h8M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" /></svg>'],
            ],
        ],
    ];
@endphp

<aside id="ownerSidebar" class="sticky inset-y-0 left-0 z-40 w-72 -translate-x-full border-r border-slate-200 bg-white shadow-xl transition-transform duration-200 lg:static lg:w-72 lg:translate-x-0 lg:shadow-none">
    <div class="flex h-full flex-col">
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-900 text-sm font-bold text-white">VS</div>
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-500">Shop owner</p>
                    <h2 class="text-sm font-semibold text-slate-900">Control center</h2>
                </div>
            </div>

            <button
                id="ownerSidebarClose"
                type="button"
                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:bg-slate-50 lg:hidden"
                aria-label="Close sidebar"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="flex-1 space-y-6 overflow-y-auto px-4 py-5">
            @foreach ($navGroups as $group)
                <div>
                    <p class="mb-2 px-2 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">{{ $group['label'] }}</p>

                    <div class="space-y-1.5">
                        @foreach ($group['items'] as $item)
                            @php
                                $href = route($item['route']);
                                $isActive = request()->routeIs($item['route']);
                            @endphp

                            <a href="{{ $href }}" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ $isActive ? 'border border-slate-200 bg-slate-100 text-slate-900 shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg {{ $isActive ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 group-hover:bg-slate-200 group-hover:text-slate-900' }}">
                                    {!! $item['icon'] !!}
                                </span>
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </nav>

        <div class="border-t border-slate-200 p-4">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div class="mb-2 flex items-center justify-between text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">
                    <span>Store status</span>
                    <span class="rounded-full bg-emerald-100 px-2 py-1 text-[10px] font-bold text-emerald-700">Live</span>
                </div>
                <p class="text-sm font-semibold text-slate-900">Business is active</p>
                <p class="mt-1 text-xs text-slate-500">Inventory updates are synced in real time.</p>
            </div>
        </div>
    </div>
</aside>

<div id="ownerSidebarOverlay" class="fixed inset-0 z-30 hidden bg-slate-950/40 lg:hidden"></div>