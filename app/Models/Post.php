<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'tenant_id',
        'product_id',
        'service_id',
        'service_category_id',
        'product_category_id',
        'name',
        'slug',
        'type',
        'attachment',
        'image',
        'price',
        'description',
        'status',
        'archived_at',
    ];
}
