<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoadSideRequest extends Model
{
    protected $fillable = [
        'tenant_id',
        'customer_id',
        'vehicle_id',
        'request_number',
        'latitude',
        'longitude',
        'address',
        'problem_type',
        'description',
        'status',
        'requested_at',
        'accepted_at',
        'completed_at',
    ];
}
