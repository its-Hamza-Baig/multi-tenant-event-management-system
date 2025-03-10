<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'capacity', 'event_type', 'price'
    ];
    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
        'capacity'   => 'integer',
    ];


    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
