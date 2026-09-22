<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'tenant_id',
        'service_category_id',
        'name',
        'description',
        'duration_minutes',
        'price',
        'is_vehicle_service',
        'is_active',
    ];
}
