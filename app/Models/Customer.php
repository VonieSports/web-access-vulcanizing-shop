<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'birth_date',
        'email',
        'phone',
        'address',
        'avatar',
        'cover_photo',
        'is_active',
        'last_login_at',
        'last_logout_at',
        'email_verified_at',
        'password',
        'remember_token',
    ];
}
