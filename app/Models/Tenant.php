<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'phone',
        'email',
        'address',
        'logo',
        'is_active',
        'business_setup_completed',
        'business_hours',
        'attachment',
        'latitude',
        'longitude',
        'verification_status',
        'rejection_reason',
        'missing_requirements',
        'submitted_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'business_setup_completed' => 'boolean',
        'business_hours' => 'array',
        'attachment' => 'array',
        'missing_requirements' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function productCategories(): HasMany
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }
}
