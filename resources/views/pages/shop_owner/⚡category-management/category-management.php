<?php

use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.shop_owner')] class extends Component
{
    public string $name = '';
    public string $description = '';
    public array $categories = [];

    public function mount(): void
    {
        $this->loadCategories();
    }

    public function loadCategories(): void
    {
        $tenant = Auth::user()?->tenant;

        $this->categories = ProductCategory::query()
            ->when($tenant, fn ($query) => $query->where('tenant_id', $tenant->id), fn ($query) => $query->whereRaw('0 = 1'))
            ->orderBy('name')
            ->get()
            ->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
            ])
            ->toArray();
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
        ]);

        ProductCategory::create([
            'tenant_id' => $tenant->id,
            'name' => $this->name,
            'slug' => Str::slug($this->name) ?: 'category',
            'description' => $this->description,
        ]);

        $this->reset(['name', 'description']);
        $this->loadCategories();
        session()->flash('success', 'Category created successfully.');
    }

};