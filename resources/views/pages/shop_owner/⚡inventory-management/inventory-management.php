<?php

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.shop_owner')] class extends Component
{
    public int $product_id = 0;
    public string $type = 'stock_in';
    public int $quantity = 1;
    public string $remarks = '';
    public array $products = [];
    public array $inventory = [];

    public function mount(): void
    {
        $this->loadData();
    }

    public function selectProduct(int $productId): void
    {
        $this->product_id = $productId;
    }

    public function loadData(): void
    {
        $tenant = Auth::user()?->tenant;

        $this->products = Product::query()
            ->when($tenant, fn ($query) => $query->where('tenant_id', $tenant->id), fn ($query) => $query->whereRaw('0 = 1'))
            ->select(['id', 'name', 'ft_img', 'selling_price', 'stock'])
            ->orderBy('name')
            ->get()
            ->map(fn ($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->ft_img ? asset('storage/' . $product->ft_img) : 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" viewBox="0 0 160 160"><rect width="160" height="160" rx="28" fill="#f1f5f9"/><rect x="30" y="30" width="100" height="100" rx="20" fill="#dbeafe"/><path d="M80 55l28 14v32l-28 14-28-14V69l28-14zm0 0v26m-28 14l28 14 28-14" stroke="#0f172a" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>'),
                'stock' => (int) $product->stock,
                'price' => (float) $product->selling_price,
            ])
            ->toArray();

        if (! $tenant) {
            $this->inventory = [];
            return;
        }

        if ($this->product_id === 0 && ! empty($this->products)) {
            $this->product_id = (int) $this->products[0]['id'];
        }

        $this->inventory = Inventory::query()
            ->with('product:id,name,ft_img,selling_price')
            ->where('tenant_id', $tenant->id)
            ->latest()
            ->get()
            ->map(fn ($entry) => [
                'id' => $entry->id,
                'product_name' => $entry->product?->name ?? 'Product removed',
                'product_image' => $entry->product?->ft_img ? asset('storage/' . $entry->product->ft_img) : 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" viewBox="0 0 160 160"><rect width="160" height="160" rx="28" fill="#f1f5f9"/><rect x="30" y="30" width="100" height="100" rx="20" fill="#dbeafe"/><path d="M80 55l28 14v32l-28 14-28-14V69l28-14zm0 0v26m-28 14l28 14 28-14" stroke="#0f172a" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>'),
                'type' => $entry->type,
                'quantity' => (int) $entry->quantity,
                'stock' => (int) $entry->after_stock,
                'price' => (float) ($entry->product?->selling_price ?? 0),
                'remarks' => $entry->remarks,
                'created_at' => $entry->created_at?->format('M d, Y h:i A'),
            ])
            ->toArray();
    }

    public function addStock(): void
    {
        $tenant = Auth::user()?->tenant;

        if (! $tenant) {
            session()->flash('error', 'No tenant account is linked to this owner profile.');
            return;
        }

        if ($this->product_id === 0) {
            session()->flash('error', 'Select a product to update stock.');
            return;
        }

        $this->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required', 'in:stock_in,stock_out,adjustment'],
            'quantity' => ['required', 'integer', 'min:1'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ]);

        $product = Product::findOrFail($this->product_id);
        $beforeStock = (int) $product->stock;
        $quantity = (int) $this->quantity;

        if ($this->type === 'stock_out' && $beforeStock < $quantity) {
            session()->flash('error', 'Cannot reduce stock beyond the current stock level.');
            return;
        }

        $afterStock = $this->type === 'stock_out'
            ? $beforeStock - $quantity
            : $beforeStock + $quantity;

        $product->stock = $afterStock;
        $product->save();

        Inventory::create([
            'tenant_id' => $tenant->id,
            'product_id' => $product->id,
            'type' => $this->type,
            'quantity' => $quantity,
            'before_stock' => $beforeStock,
            'after_stock' => $afterStock,
            'reference_type' => 'owner_inventory',
            'reference_id' => $product->id,
            'remarks' => $this->remarks ?: 'Stock updated by owner.',
        ]);

        $this->reset(['type', 'quantity', 'remarks']);
        $this->quantity = 1;
        $this->type = 'stock_in';
        $this->loadData();
        session()->flash('success', 'Inventory updated successfully.');
    }
};