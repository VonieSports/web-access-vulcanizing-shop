<?php

use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Variant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.shop_owner')] class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $description = '';
    public string $category_id = '';
    public string $barcode = '';
    public int $stock = 0;
    public float $cost_price = 0;
    public float $selling_price = 0;
    public int $low_stock_alert = 5;
    public $mainImage;
    public array $attachmentImages = [];
    public bool $hasVariants = false;
    public array $variantGroups = [
        ['title' => 'Color', 'options' => ['Red', 'Blue', 'Black']],
    ];
    public array $categories = [];
    public string $newCategoryName = '';
    public string $newCategoryDescription = '';

    public function mount(): void
    {
        $tenant = Auth::user()?->tenant;

        $this->categories = ProductCategory::query()
            ->when($tenant, fn ($query) => $query->where('tenant_id', $tenant->id), fn ($query) => $query->whereRaw('0 = 1'))
            ->orderBy('name')
            ->get()
            ->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
            ])
            ->toArray();
    }

    public function addVariantGroup(): void
    {
        if (count($this->variantGroups) >= 3) {
            return;
        }

        $this->variantGroups[] = ['title' => '', 'options' => ['']];
    }

    public function removeVariantGroup(int $index): void
    {
        if (count($this->variantGroups) <= 1) {
            return;
        }

        unset($this->variantGroups[$index]);
        $this->variantGroups = array_values($this->variantGroups);
    }

    public function addOption(int $groupIndex): void
    {
        if (! isset($this->variantGroups[$groupIndex])) {
            return;
        }

        $this->variantGroups[$groupIndex]['options'][] = '';
    }

    public function removeOption(int $groupIndex, int $optionIndex): void
    {
        if (! isset($this->variantGroups[$groupIndex]['options'][$optionIndex])) {
            return;
        }

        unset($this->variantGroups[$groupIndex]['options'][$optionIndex]);
        $this->variantGroups[$groupIndex]['options'] = array_values($this->variantGroups[$groupIndex]['options']);
    }

    public function createInlineCategory(): void
    {
        $tenant = Auth::user()?->tenant;

        if (! $tenant) {
            session()->flash('error', 'No tenant account is linked to this owner profile.');
            return;
        }

        $this->validate([
            'newCategoryName' => ['nullable', 'string', 'min:2', 'max:255'],
            'newCategoryDescription' => ['nullable', 'string', 'max:500'],
        ]);

        if (trim($this->newCategoryName) === '') {
            return;
        }

        $category = ProductCategory::create([
            'tenant_id' => $tenant->id,
            'name' => trim($this->newCategoryName),
            'slug' => Str::slug(trim($this->newCategoryName)) ?: 'category',
            'description' => trim($this->newCategoryDescription),
        ]);

        $this->category_id = (string) $category->id;
        $this->newCategoryName = '';
        $this->newCategoryDescription = '';
        $this->mount();
    }

    public function save(): void
    {
        $tenant = Auth::user()?->tenant;

        if (! $tenant) {
            session()->flash('error', 'No tenant account is linked to this owner profile.');
            return;
        }

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:product_categories,id'],
            'barcode' => ['nullable', 'string', 'max:100'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'low_stock_alert' => ['required', 'integer', 'min:0'],
            'mainImage' => ['required', 'image', 'max:2048'],
            'attachmentImages' => ['nullable', 'array', 'max:5'],
            'attachmentImages.*' => ['image', 'max:2048'],
            'variantGroups' => ['nullable', 'array'],
            'variantGroups.*.title' => ['nullable', 'string', 'max:100'],
            'variantGroups.*.options' => ['nullable', 'array'],
            'variantGroups.*.options.*' => ['nullable', 'string', 'max:100'],
        ]);

        $mainImagePath = $this->mainImage?->store("tenant/{$tenant->id}/products/main", 'public');
        $attachmentPaths = [];

        foreach ($this->attachmentImages as $attachment) {
            $attachmentPaths[] = $attachment->store("tenant/{$tenant->id}/products/attachments", 'public');
        }

        $slug = Str::slug($this->name) ?: 'product';
        $sku = strtoupper(Str::slug($this->name, '-')) . '-' . Str::upper(Str::random(4));
        $productStock = $this->hasVariants ? 0 : (int) $this->stock;

        $product = Product::create([
            'tenant_id' => $tenant->id,
            'category_id' => $this->category_id,
            'brand_id' => null,
            'name' => $this->name,
            'slug' => $slug,
            'sku' => $sku,
            'barcode' => $this->barcode ?: null,
            'cost_price' => $this->cost_price,
            'selling_price' => $this->selling_price,
            'stock' => $productStock,
            'low_stock_alert' => $this->low_stock_alert,
            'description' => $this->description,
            'ft_img' => $mainImagePath,
            'attachments' => $attachmentPaths,
        ]);

        if (! $this->hasVariants) {
            Inventory::create([
                'tenant_id' => $tenant->id,
                'product_id' => $product->id,
                'type' => 'stock_in',
                'quantity' => $productStock,
                'before_stock' => 0,
                'after_stock' => $productStock,
                'reference_type' => 'product_post',
                'reference_id' => $product->id,
                'remarks' => 'Initial stock added on product creation.',
            ]);
        }

        if ($this->hasVariants) {
            $variantCombos = $this->buildVariantCombinations($this->variantGroups);
            $variantTotal = 0;

            foreach ($variantCombos as $combo) {
                $label = $this->variantLabel($combo);
                $variantStock = 0;
                $variantPrice = $this->selling_price;
                $variantImage = null;

                $variant = Variant::create([
                    'tenant_id' => $tenant->id,
                    'product_id' => $product->id,
                    'sku' => $label,
                    'price' => $variantPrice,
                    'stock_quantity' => $variantStock,
                    'image' => $variantImage,
                ]);

                $variantTotal += $variant->stock_quantity;
            }

            $product->stock = $variantTotal;
            $product->save();
        }

        $this->reset([
            'name',
            'description',
            'category_id',
            'barcode',
            'stock',
            'cost_price',
            'selling_price',
            'low_stock_alert',
            'mainImage',
            'attachmentImages',
            'hasVariants',
            'variantGroups',
            'newCategoryName',
            'newCategoryDescription',
        ]);

        $this->variantGroups = [['title' => 'Color', 'options' => ['Red', 'Blue', 'Black']]];

        session()->flash('success', 'Product post created successfully.');
        $this->redirectRoute('owner.products');
    }

    protected function buildVariantCombinations(array $groups): array
    {
        $results = [[]];

        foreach ($groups as $group) {
            $groupTitle = trim((string) ($group['title'] ?? ''));
            $options = array_values(array_filter(array_map(fn ($option) => trim((string) $option), $group['options'] ?? []), fn ($option) => $option !== ''));

            if ($groupTitle === '' || $options === []) {
                continue;
            }

            $newResults = [];
            foreach ($results as $result) {
                foreach ($options as $option) {
                    $newResults[] = array_merge($result, [$groupTitle => $option]);
                }
            }

            $results = $newResults;
        }

        return $results;
    }

    protected function variantLabel(array $combo): string
    {
        $parts = [];

        foreach ($combo as $title => $option) {
            $parts[] = $title . ': ' . $option;
        }

        return implode(' | ', $parts);
    }
};
