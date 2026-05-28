<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'blood_bank_id',
        'title',
        'description',
        'event_date',
        'location',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function bloodBank()
    {
        return $this->belongsTo(BloodBank::class);
    }
}
