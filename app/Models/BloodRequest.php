<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    protected $fillable = [
        'requester_name',
        'blood_group',
        'units_needed',
        'hospital',
        'city',
        'urgency',
        'status',
    ];
}
