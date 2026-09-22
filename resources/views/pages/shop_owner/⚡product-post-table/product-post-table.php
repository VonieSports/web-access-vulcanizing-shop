<?php

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.shop_owner')] class extends Component
{
    public array $products = [];

    public function mount(): void
    {
        $tenant = Auth::user()?->tenant;

        if (! $tenant) {
            $this->products = [];
            return;
        }

        $this->products = Product::query()
            ->with(['category', 'variants'])
            ->where('tenant_id', $tenant->id)
            ->latest()
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'category' => $product->category?->name ?? 'Uncategorized',
                    'stock' => (int) $product->stock,
                    'price' => (float) $product->selling_price,
                    'image' => $product->ft_img ? asset('storage/' . $product->ft_img) : asset('images/default-product.png'),
                    'description' => $product->description,
                    'variants_count' => $product->variants->count(),
                    'sku' => $product->sku,
                    'created_at' => $product->created_at?->format('M d, Y'),
                ];
            })
            ->toArray();
    }
};
