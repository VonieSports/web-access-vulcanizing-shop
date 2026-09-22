<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'tenant_id',
        'brand_name',
        'brand_slug',
    ];
}
