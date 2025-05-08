<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Address extends Model

{

    protected $fillable = [

        'addressable_id', 'addressable_type', 'type', 'street', 'city',

        'state', 'country', 'postal_code', 'latitude', 'longitude'

    ];

    public function addressable()

    {

        return $this->morphTo();

    }

    public function pickupOrders()

    {

        return $this->hasMany(Order::class, 'pickup_address_id');

    }

    public function dropoffOrders()

    {

        return $this->hasMany(Order::class, 'dropoff_address_id');

    }

}

