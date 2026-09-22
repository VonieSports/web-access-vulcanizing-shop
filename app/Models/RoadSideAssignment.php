<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoadSideAssignment extends Model
{
    protected $fillable = [
        'tenant_id',
        'roadside_request_id',
        'employee_id',
        'assigned_at',
        'arrival_at',
        'completed_at',
        'status',
    ];
}
