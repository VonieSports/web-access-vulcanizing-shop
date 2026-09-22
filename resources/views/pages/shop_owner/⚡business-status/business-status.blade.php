<div class="space-y-6">
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-slate-500">Business verification</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Application status</h1>
            </div>

            @php
                $statusClasses = [
                    'pending' => 'border-amber-200 bg-amber-50 text-amber-700',
                    'approved' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                    'rejected' => 'border-red-200 bg-red-50 text-red-700',
                    'suspended' => 'border-slate-200 bg-slate-100 text-slate-700',
                ];
            @endphp

            <span class="rounded-full border px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.16em] {{ $statusClasses[$status ?? 'pending'] ?? 'border-slate-200 bg-slate-100 text-slate-700' }}">
                {{ ucfirst(str_replace('_', ' ', $status ?? 'pending')) }}
            </span>
        </div>

        @if (session('success'))
            <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (($status ?? null) === 'pending')
            <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-sm text-amber-800">
                Your business profile has been submitted and is waiting for admin review. You will be able to access the owner dashboard only after approval.
            </div>
        @elseif (($status ?? null) === 'approved')
            <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-5 text-sm text-emerald-800">
                Your business has been approved. You can now access all owner tools and continue managing your storefront.
            </div>
        @elseif (($status ?? null) === 'rejected')
            <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-sm text-red-700">
                <p class="font-semibold">Your submission was rejected.</p>
                @if (! empty($rejectionReason))
                    <p class="mt-2">Reason: {{ $rejectionReason }}</p>
                @endif
                @if (! empty($missingRequirements))
                    <ul class="mt-3 list-disc space-y-1 pl-5">
                        @foreach ($missingRequirements as $requirement)
                            <li>{{ $requirement }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="mt-6 flex justify-end">
                <button wire:click="retrySubmission" type="button" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Resubmit business profile
                </button>
            </div>
        @else
            <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-5 text-sm text-slate-600">
                Your current verification status is being reviewed by the platform team.
            </div>
        @endif
    </div>
</div>
