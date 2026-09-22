<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'tenant_id',
        'customer_id',
        'service_id',
        'employee_id',
        'sale_id',
        'rating',
        'review',
    ];
}
