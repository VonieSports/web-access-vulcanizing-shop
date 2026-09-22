
<div class="space-y-6">
    <div class="mx-auto mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="mb-2 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Owner portal</p>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Create product post</h1>
        </div>

        <a href="{{ route('owner.products') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
            View products
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

    <form wire:submit="save" class="space-y-6">
        <div class="grid gap-6 xl:grid-cols-[1.5fr_0.95fr]">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-900">Product details</h2>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Product name</label>
                        <input wire:model="name" type="text" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:bg-white focus:ring-2 focus:ring-orange-100" placeholder="e.g. Heavy Duty Tire Kit" />
                        @error('name') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Description</label>
                        <textarea wire:model="description" rows="5" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:bg-white focus:ring-2 focus:ring-orange-100" placeholder="Describe the product, specifications, and usage."></textarea>
                        @error('description') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Category</label>
                            <select wire:model="category_id" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:bg-white focus:ring-2 focus:ring-orange-100">
                                <option value="">Select category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Barcode</label>
                            <input wire:model="barcode" type="text" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:bg-white focus:ring-2 focus:ring-orange-100" placeholder="Optional barcode" />
                            @error('barcode') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-4">
                        <div class="mb-2 flex items-center justify-between gap-3">
                            <label class="block text-sm font-medium text-slate-700">Create category inline</label>
                            <button type="button" wire:click="createInlineCategory" class="rounded-lg bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white">Save new category</button>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <input wire:model="newCategoryName" type="text" placeholder="New category name" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100" />
                            <input wire:model="newCategoryDescription" type="text" placeholder="Optional description" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100" />
                        </div>
                        @error('newCategoryName') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                        @error('newCategoryDescription') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Stock</label>
                            <input wire:model="stock" type="number" min="0" @if($hasVariants) disabled @endif class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:bg-white focus:ring-2 focus:ring-orange-100 disabled:cursor-not-allowed disabled:opacity-60" />
                            @error('stock') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Cost price</label>
                            <input wire:model="cost_price" type="number" min="0" step="0.01" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:bg-white focus:ring-2 focus:ring-orange-100" />
                            @error('cost_price') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Selling price</label>
                            <input wire:model="selling_price" type="number" min="0" step="0.01" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:bg-white focus:ring-2 focus:ring-orange-100" />
                            @error('selling_price') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Low stock alert</label>
                        <input wire:model="low_stock_alert" type="number" min="0" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:bg-white focus:ring-2 focus:ring-orange-100" />
                        @error('low_stock_alert') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">Main image</h2>
                    </div>

                    <div data-image-preview class="space-y-3">
                        <label class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-5 text-center transition hover:border-slate-400 hover:bg-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-3 h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-8-6h.01M6 20h12a2 2 0 002-2V8a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm font-medium text-slate-700">Upload main image</span>
                            <input wire:model="mainImage" type="file" accept="image/*" class="hidden" />
                        </label>

                        @if ($mainImage)
                            <img src="{{ $mainImage->temporaryUrl() }}" alt="Main preview" class="h-44 w-full rounded-xl object-cover" />
                        @endif
                        @error('mainImage') <span class="block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">Additional attachments</h2>
                        <span class="rounded-full bg-orange-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-orange-700">Up to 5</span>
                    </div>

                    <label class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-5 text-center transition hover:border-slate-400 hover:bg-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mb-3 h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8h-16" />
                        </svg>
                        <span class="text-sm font-medium text-slate-700">Upload product images</span>
                        <input wire:model="attachmentImages" type="file" accept="image/*" multiple class="hidden" />
                    </label>

                    @if ($attachmentImages)
                        <div class="mt-4 grid grid-cols-2 gap-3">
                            @foreach ($attachmentImages as $attachment)
                                <img src="{{ $attachment->temporaryUrl() }}" alt="Attachment preview" class="h-20 w-full rounded-xl object-cover" />
                            @endforeach
                        </div>
                    @endif
                    @error('attachmentImages') <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="mb-1 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Variants</p>
                    <h2 class="text-lg font-semibold text-slate-900">Product variants</h2>
                </div>

                <label class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
                    <input type="checkbox" wire:model.live="hasVariants" class="h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-400" />
                    Use variants
                </label>
            </div>

            @if ($hasVariants)
                <div class="mb-4 flex items-center justify-between">
                    <p class="text-sm text-slate-600">Add up to 3 attribute groups such as Color, Size, or Material.</p>
                    <button type="button" wire:click="addVariantGroup" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Add attribute
                    </button>
                </div>

                <div class="space-y-4">
                    @foreach ($variantGroups as $groupIndex => $group)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="mb-4 flex items-center justify-between gap-3">
                                <div class="flex-1">
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Attribute title</label>
                                    <input wire:model="variantGroups.{{ $groupIndex }}.title" type="text" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100" placeholder="Color" />
                                </div>
                                @if (count($variantGroups) > 1)
                                    <button type="button" wire:click="removeVariantGroup({{ $groupIndex }})" class="rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-600">Remove</button>
                                @endif
                            </div>

                            <div class="space-y-3">
                                @foreach ($group['options'] as $optionIndex => $option)
                                    <div class="flex items-center gap-2">
                                        <input wire:model="variantGroups.{{ $groupIndex }}.options.{{ $optionIndex }}" type="text" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100" placeholder="Enter option value" />
                                        @if (count($group['options']) > 1)
                                            <button type="button" wire:click="removeOption({{ $groupIndex }}, {{ $optionIndex }})" class="rounded-lg border border-slate-200 bg-white px-2 py-2 text-xs font-semibold text-slate-600">Delete</button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-3 flex justify-end">
                                <button type="button" wire:click="addOption({{ $groupIndex }})" class="rounded-lg bg-white px-3 py-2 text-xs font-semibold text-slate-700 border border-slate-200">Add option</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-5 text-sm text-slate-500">
                    Single product stock will be used without variant attributes.
                </div>
            @endif
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-orange-500 to-orange-400 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-200 transition hover:from-orange-600 hover:to-orange-500">
                Create product post
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        document.querySelectorAll('[data-image-preview]').forEach((container) => {
            const input = container.querySelector('input[type="file"]');
            const preview = container.querySelector('img');

            if (!input || !preview) return;

            input.addEventListener('change', (event) => {
                const file = event.target.files && event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (loadEvent) => {
                    preview.src = loadEvent.target.result;
                };
                reader.readAsDataURL(file);
            });
        });
    });
</script>
