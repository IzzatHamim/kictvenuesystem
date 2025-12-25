<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = [
        'name',
        'description',
        'capacity',
        'price_per_hour',
        'location',
        'image',
        'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}