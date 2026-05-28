<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodBank extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'contact',
        'verified',
        'latitude',
        'longitude',
    ];

    public function stocks()
    {
        return $this->hasMany(BloodStock::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
