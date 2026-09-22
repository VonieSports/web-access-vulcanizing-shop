<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoadSideService extends Model
{
    protected $fillable = [
        'tenant_id',
        'roadside_request_id',
        'service_id',
        'price',
    ];
}
