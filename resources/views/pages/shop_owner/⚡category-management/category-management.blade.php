<div class="space-y-6">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="mb-2 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Catalog</p>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Category management</h1>
        </div>

        <a href="{{ route('owner.product_create') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
            Create product
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
            <h2 class="mb-4 text-lg font-semibold text-slate-900">Add category</h2>

            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Category name</label>
                    <input wire:model="name" type="text" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:bg-white focus:ring-2 focus:ring-orange-100" placeholder="e.g. Tires" />
                    @error('name') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Description</label>
                    <textarea wire:model="description" rows="4" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:bg-white focus:ring-2 focus:ring-orange-100" placeholder="Category description"></textarea>
                    @error('description') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-orange-500 to-orange-400 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-200 transition hover:from-orange-600 hover:to-orange-500">
                    Save category
                </button>
            </form>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">Categories</h2>
                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">{{ count($categories) }}</span>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                    <thead class="bg-slate-50 text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Slug</th>
                            <th class="px-4 py-3">Description</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($categories as $category)
                            <tr>
                                <td class="px-4 py-3 font-semibold text-slate-900">{{ $category['name'] }}</td>
                                <td class="px-4 py-3 text-slate-600">/{{ $category['slug'] }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $category['description'] ?: 'No description' }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full bg-orange-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-orange-700">Active</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">No categories created yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
