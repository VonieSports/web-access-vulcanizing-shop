
<div class="space-y-6">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Product Table</h1>
        </div>

        <a href="{{ route('owner.product_create') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
            New product
        </a>
    </div>

    <div class="grid gap-4 md:grid-cols-2 2xl:grid-cols-3">
        @forelse ($products as $product)
            <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="relative">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="h-56 w-full object-cover" />
                    <span class="absolute left-4 top-4 rounded-full bg-white/90 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-700 backdrop-blur">{{ $product['category'] }}</span>
                </div>

                <div class="space-y-4 p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">{{ $product['name'] }}</h2>
                            <p class="mt-1 text-xs font-medium uppercase tracking-[0.18em] text-slate-500">{{ $product['sku'] }}</p>
                        </div>
                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-emerald-700">{{ $product['stock'] }} in stock</span>
                    </div>

                    <p class="line-clamp-3 text-sm leading-6 text-slate-600">{{ $product['description'] ?: 'No description added for this product yet.' }}</p>

                    <div class="grid grid-cols-2 gap-3 text-sm text-slate-600">
                        <div class="rounded-xl bg-slate-50 p-3">
                            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Price</p>
                            <p class="mt-2 text-base font-semibold text-slate-900">₱{{ number_format($product['price'], 2) }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-3">
                            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Variants</p>
                            <p class="mt-2 text-base font-semibold text-slate-900">{{ $product['variants_count'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between border-t border-slate-200 pt-4 text-xs font-medium text-slate-500">
                        <span>Created {{ $product['created_at'] }}</span>
                        <a href="{{ route('owner.inventory') }}" class="font-semibold text-orange-600 transition hover:text-orange-700">Add stock</a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500">
                No product posts have been created yet.
            </div>
        @endforelse
    </div>
</div>