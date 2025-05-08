<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Driver extends User
{
    protected $fillable = [
        'user_id', 'area_id', 'vehicle_type', 'vehicle_number',
        'pricing_model', 'rate_per_km', 'fixed_rate', 'rating'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function getAvailability()
    {
        return $this->belongsToMany(Availability::class, 'driver_availability')
            ->withTimestamps();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }
}
