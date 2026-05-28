<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'blood_group',
        'city',
        'is_available',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
    ];
}
