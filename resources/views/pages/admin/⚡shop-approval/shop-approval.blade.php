<div class="space-y-6">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="mb-2 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Platform management</p>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Shop approval queue</h1>
        </div>
        <div class="rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600">
            {{ count($shops) }} submissions
        </div>
    </div>

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if (empty($shops))
        <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">
            No business submissions are waiting for review.
        </div>
    @else
        <div class="space-y-4">
            @foreach ($shops as $shop)
                @php
                    $statusColor = match ($shop['status']) {
                        'approved' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                        'rejected' => 'border-red-200 bg-red-50 text-red-700',
                        'pending' => 'border-amber-200 bg-amber-50 text-amber-700',
                        default => 'border-slate-200 bg-slate-100 text-slate-700',
                    };
                @endphp

                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <h2 class="text-xl font-semibold text-slate-900">{{ $shop['shop_name'] }}</h2>
                                <span class="rounded-full border px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.16em] {{ $statusColor }}">
                                    {{ ucfirst($shop['status']) }}
                                </span>
                            </div>

                            <div class="grid gap-3 text-sm text-slate-600 md:grid-cols-2">
                                <div><span class="font-medium text-slate-800">Owner:</span> {{ $shop['owner_name'] }}</div>
                                <div><span class="font-medium text-slate-800">Email:</span> {{ $shop['owner_email'] }}</div>
                                <div><span class="font-medium text-slate-800">Phone:</span> {{ $shop['phone'] }}</div>
                                <div><span class="font-medium text-slate-800">Submitted:</span> {{ $shop['submitted_at'] }}</div>
                            </div>

                            <div class="text-sm text-slate-600">
                                <span class="font-medium text-slate-800">Address:</span> {{ $shop['address'] }}
                            </div>

                            @if (! empty($shop['rejection_reason']))
                                <div class="rounded-2xl border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
                                    <span class="font-semibold">Reject reason:</span> {{ $shop['rejection_reason'] }}
                                </div>
                            @endif

                            @if (! empty($shop['missing_requirements']))
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-600">
                                    <span class="font-semibold text-slate-800">Missing requirements:</span>
                                    <ul class="mt-2 list-disc space-y-1 pl-5">
                                        @foreach ($shop['missing_requirements'] as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if ($shop['attachment'])
                                <a href="{{ asset('storage/' . $shop['attachment']) }}" target="_blank" class="inline-flex items-center rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                                    View attachment
                                </a>
                            @endif
                        </div>

                        @if ($shop['status'] !== 'approved')
                            <div class="flex flex-col gap-3 sm:flex-row lg:flex-col">
                                <button wire:click="approve({{ $shop['id'] }})" type="button" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-500">
                                    Approve
                                </button>
                                <button wire:click="reject({{ $shop['id'] }})" type="button" class="inline-flex items-center justify-center rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-700 transition hover:bg-red-100">
                                    Reject
                                </button>
                            </div>
                        @else
                            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-emerald-700">
                                Approved
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>