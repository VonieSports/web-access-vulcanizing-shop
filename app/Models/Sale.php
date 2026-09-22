<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'tenant_id',
        'customer_id',
        'appointment_id',
        'roadside_request_id',
        'served_by',
        'invoice_number',
        'subtotal',
        'discount',
        'tax',
        'final_amount',
        'payment_method',
        'status',
    ];
}
