<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'tenant_id',
        'user_id',
        'name',
        'position',
        'commission_rate',
        'phone',
        'hired_at',
        'is_active',
    ];
}
