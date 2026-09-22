<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'tenant_id',
        'customer_id',
        'vehicle_id',
        'employee_id',
        'created_by',
        'appointment_number',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];
}
