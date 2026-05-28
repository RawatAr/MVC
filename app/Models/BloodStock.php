<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodStock extends Model
{
    protected $fillable = [
        'blood_bank_id',
        'blood_group',
        'units_available',
    ];

    public function bloodBank()
    {
        return $this->belongsTo(BloodBank::class);
    }
}
