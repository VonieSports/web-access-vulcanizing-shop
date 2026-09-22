<div class="space-y-6">
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-slate-500">Business setup</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Submit your shop details</h1>
            </div>
            <div class="rounded-full border border-orange-200 bg-orange-50 px-3 py-1.5 text-xs font-semibold text-orange-700">
                Approval review required
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit="save" class="space-y-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Shop name</label>
                    <input wire:model.defer="shop_name" type="text" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-900 focus:bg-white focus:ring-4 focus:ring-slate-100" placeholder="e.g. RoadMaster Tire Hub" />
                    @error('shop_name') <span class="mt-2 block text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Business email</label>
                    <input wire:model.defer="shop_email" type="email" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-900 focus:bg-white focus:ring-4 focus:ring-slate-100" placeholder="business@shop.com" />
                    @error('shop_email') <span class="mt-2 block text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Business contact</label>
                    <input wire:model.defer="phone" type="text" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-900 focus:bg-white focus:ring-4 focus:ring-slate-100" placeholder="+63 912 345 6789" />
                    @error('phone') <span class="mt-2 block text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Business logo</label>
                    <input wire:model="logo" type="file" accept="image/*" class="block w-full rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-4 text-sm text-slate-600 file:mr-4 file:rounded-full file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white" />
                    @error('logo') <span class="mt-2 block text-sm text-red-600">{{ $message }}</span> @enderror

                    @if ($logo)
                        <div class="mt-3 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 p-3">
                            <img src="{{ $logo->temporaryUrl() }}" alt="Business logo preview" class="h-20 w-20 rounded-xl object-cover" />
                        </div>
                    @endif
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700">Business hours</label>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                        @foreach ($dayNames as $day)
                            <div class="grid grid-cols-[100px_1fr_1fr] items-center gap-3 py-2">
                                <span class="text-sm font-medium text-slate-700">{{ $day }}</span>
                                <select wire:model="business_hours.{{ $day }}.open" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none focus:border-slate-900">
                                    @foreach ($timeOptions as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <select wire:model="business_hours.{{ $day }}.close" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none focus:border-slate-900">
                                    @foreach ($timeOptions as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                    @error('business_hours') <span class="mt-2 block text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Business address</label>
                <textarea wire:model.defer="address" rows="4" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-900 focus:bg-white focus:ring-4 focus:ring-slate-100" placeholder="Street address, city, region"></textarea>
                @error('address') <span class="mt-2 block text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Permit / business documents</label>
                <input wire:model="permit_documents" type="file" multiple class="block w-full rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-4 text-sm text-slate-600 file:mr-4 file:rounded-full file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white" />
                @error('permit_documents') <span class="mt-2 block text-sm text-red-600">{{ $message }}</span> @enderror

                @if (! empty($permit_documents))
                    <div class="mt-3 space-y-2">
                        @foreach ($permit_documents as $permit)
                            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-700">
                                Selected: {{ $permit->getClientOriginalName() }}
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Submit for approval
                </button>
            </div>
        </form>
    </div>
</div>
