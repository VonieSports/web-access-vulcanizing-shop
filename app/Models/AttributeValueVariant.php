<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValueVariant extends Model
{
    protected $fillable =[
        'variant_id',
        'attribute_value_id',
    ];
}
