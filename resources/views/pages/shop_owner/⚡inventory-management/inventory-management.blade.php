
<div class="space-y-6">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="mb-2 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Stock control</p>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Inventory management</h1>
        </div>

        <a href="{{ route('owner.products') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
            View product posts
        </a>
    </div>

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid gap-6 xl:grid-cols-[0.9fr_1.4fr]">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="mb-4 text-lg font-semibold text-slate-900">Adjust stock</h2>

            <form wire:submit="addStock" class="space-y-4">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                    <div class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">Selected product</div>
                    @if (! empty($products))
                        <div class="flex flex-wrap gap-2">
                            @foreach($products as $product)
                                <button type="button" wire:click="selectProduct({{ $product['id'] }})" class="rounded-full border px-3 py-1.5 text-xs font-semibold {{ $product_id === $product['id'] ? 'border-orange-200 bg-orange-100 text-orange-700' : 'border-slate-200 bg-white text-slate-600' }}">
                                    {{ $product['name'] }}
                                </button>
                            @endforeach
                        </div>
                    @else
                        <div class="text-sm text-slate-500">No products available yet.</div>
                    @endif
                    @error('product_id') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Type</label>
                    <select wire:model="type" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:bg-white focus:ring-2 focus:ring-orange-100">
                        <option value="stock_in">Stock in</option>
                        <option value="stock_out">Stock out</option>
                        <option value="adjustment">Adjustment</option>
                    </select>
                    @error('type') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Quantity</label>
                    <input wire:model="quantity" type="number" min="1" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:bg-white focus:ring-2 focus:ring-orange-100" />
                    @error('quantity') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Remarks</label>
                    <textarea wire:model="remarks" rows="3" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:bg-white focus:ring-2 focus:ring-orange-100" placeholder="Optional notes"></textarea>
                    @error('remarks') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-orange-500 to-orange-400 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-200 transition hover:from-orange-600 hover:to-orange-500">
                    Save inventory
                </button>
            </form>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">Recent inventory</h2>
                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">{{ count($inventory) }}</span>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                    <thead class="bg-slate-50 text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Qty</th>
                            <th class="px-4 py-3">Stock</th>
                            <th class="px-4 py-3">Updated</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($inventory as $entry)
                            <tr class="align-middle">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $entry['product_image'] }}" alt="{{ $entry['product_name'] }}" class="h-11 w-11 rounded-xl object-cover" />
                                        <div>
                                            <div class="font-semibold text-slate-900">{{ $entry['product_name'] }}</div>
                                            <div class="text-xs text-slate-500">{{ $entry['price'] ? '$' . number_format($entry['price'], 2) : '—' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">{{ $entry['type'] }}</td>
                                <td class="px-4 py-3 font-semibold text-slate-900">{{ $entry['quantity'] }}</td>
                                <td class="px-4 py-3 font-semibold text-slate-900">{{ $entry['stock'] }}</td>
                                <td class="px-4 py-3 text-slate-500">{{ $entry['created_at'] ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-sm text-slate-500">No inventory activity yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
