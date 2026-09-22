<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeLocation extends Model
{
    protected $fillable = [
        'tenant_id',
        'employee_id',
        'latitude',
        'longitude',
        'recorded_at',
    ];
}
