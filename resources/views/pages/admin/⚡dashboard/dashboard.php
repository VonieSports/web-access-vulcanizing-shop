<?php

use App\Models\Tenant;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public array $kpis = [];
    public array $chartLabels = [];
    public array $lineSeries = [];
    public array $donutSeries = [];
    public array $tenantRows = [];
    public array $reviewSummary = [];

    public function mount(): void
    {
        $tenantCount = Tenant::count();
        $activeCount = Tenant::where('is_active', true)->count();
        $pendingCount = Tenant::where('verification_status', 'pending')->count();
        $rejectedCount = Tenant::where('verification_status', 'rejected')->count();

        $this->kpis = [
            ['label' => 'Registered tenants', 'value' => (string) $tenantCount, 'delta' => '+12%', 'tone' => 'orange'],
            ['label' => 'Active shops', 'value' => (string) $activeCount, 'delta' => '+8%', 'tone' => 'green'],
            ['label' => 'Pending checks', 'value' => (string) $pendingCount, 'delta' => '-3%', 'tone' => 'amber'],
            ['label' => 'Rejected apps', 'value' => (string) $rejectedCount, 'delta' => '-1%', 'tone' => 'red'],
        ];

        $firstMonth = now()->subMonths(6)->startOfMonth();
        $months = collect(range(0, 6))->map(fn (int $offset) => $firstMonth->copy()->addMonths($offset));
        $monthlyTenantCounts = Tenant::query()
            ->whereBetween('created_at', [$firstMonth, now()->endOfMonth()])
            ->get(['created_at'])
            ->countBy(fn (Tenant $tenant) => $tenant->created_at?->format('Y-m'));

        $this->chartLabels = $months->map(fn (Carbon $month) => $month->format('M'))->all();
        $this->lineSeries = $months
            ->map(fn (Carbon $month) => $monthlyTenantCounts->get($month->format('Y-m'), 0))
            ->all();
        $this->donutSeries = [
            ['label' => 'Verified', 'value' => max($activeCount, 0), 'color' => '#ff7b2c', 'swatch' => 'bg-orange-500'],
            ['label' => 'Pending', 'value' => max($pendingCount, 0), 'color' => '#f8c86f', 'swatch' => 'bg-amber-400'],
            ['label' => 'Rejected', 'value' => max($rejectedCount, 0), 'color' => '#4f8ef7', 'swatch' => 'bg-blue-500'],
        ];

        $this->tenantRows = Tenant::latest()->take(5)->get()->map(function ($tenant) {
            return [
                'name' => $tenant->name,
                'owner' => $tenant->user?->name ?? 'Unassigned owner',
                'status' => ucfirst((string) ($tenant->verification_status ?? 'pending')),
                'created' => $tenant->created_at ? Carbon::parse($tenant->created_at)->format('M d, Y') : '—',
            ];
        })->toArray();

        $this->reviewSummary = [
            'average_rating' => 'No rating yet',
            'count' => 0,
            'message' => 'No tenant reviews have been submitted on the platform yet.',
            'has_reviews' => false,
        ];
    }
};
