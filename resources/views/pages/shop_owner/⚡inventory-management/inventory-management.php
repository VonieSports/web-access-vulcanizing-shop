<?php

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.shop_owner')] class extends Component
{
    public array $kpis = [];
    public array $chartLabels = [];
    public array $lineSeries = [];
    public array $donutSeries = [];
    public array $tableRows = [];

    public function mount(): void
    {
        $tenant = Auth::user()?->tenant;

        if (! $tenant) {
            $this->kpis = [];
            $this->chartLabels = [];
            $this->lineSeries = [];
            $this->donutSeries = [];
            $this->tableRows = [];
            return;
        }

        $products = Product::query()->where('tenant_id', $tenant->id)->select(['id', 'name', 'stock', 'selling_price'])->get();
        $inventory = Inventory::query()->where('tenant_id', $tenant->id)->latest()->limit(10)->get();

        $totalProducts = $products->count();
        $totalStock = $products->sum('stock');
        $lowStockCount = $products->filter(fn ($product) => (int) $product->stock <= 5)->count();
        $salesTotal = Sale::query()->where('tenant_id', $tenant->id)->sum('final_amount');

        $this->kpis = [
            ['label' => 'Products', 'value' => (string) $totalProducts, 'delta' => 'Live', 'tone' => 'orange'],
            ['label' => 'Stock units', 'value' => (string) $totalStock, 'delta' => 'Ready', 'tone' => 'green'],
            ['label' => 'Low stock', 'value' => (string) $lowStockCount, 'delta' => 'Check', 'tone' => 'amber'],
            ['label' => 'Sales total', 'value' => '$' . number_format((float) $salesTotal, 2), 'delta' => 'Net', 'tone' => 'red'],
        ];

        $lastSixMonths = [];
        $inventoryTrend = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthDate = now()->subMonths($i);
            $label = $monthDate->format('M');
            $lastSixMonths[] = $label;
            $inventoryTrend[] = (int) Inventory::query()
                ->where('tenant_id', $tenant->id)
                ->whereMonth('created_at', $monthDate->month)
                ->whereYear('created_at', $monthDate->year)
                ->sum('quantity');
        }

        $this->chartLabels = $lastSixMonths;
        $this->lineSeries = $inventoryTrend;

        $this->donutSeries = [
            ['label' => 'In stock', 'value' => max($products->where('stock', '>', 0)->count(), 0), 'color' => '#0f766e'],
            ['label' => 'Low stock', 'value' => $lowStockCount, 'color' => '#f59e0b'],
            ['label' => 'Out of stock', 'value' => max($products->where('stock', '<=', 0)->count(), 0), 'color' => '#ef4444'],
        ];

        $this->tableRows = $inventory
            ->map(fn ($entry) => [
                'product' => $entry->product?->name ?? 'Product removed',
                'type' => strtoupper((string) $entry->type),
                'quantity' => (int) $entry->quantity,
                'stock' => (int) $entry->after_stock,
                'updated' => $entry->created_at?->format('M d, Y'),
            ])
            ->toArray();
    }
};