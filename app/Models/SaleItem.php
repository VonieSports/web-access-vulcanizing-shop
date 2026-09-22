<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = [
        'tenant_id',
        'sale_id',
        'product_id',
        'service_id',
        'item_type',
        'quantity',
        'price',
        'subtotal',
    ];
}
