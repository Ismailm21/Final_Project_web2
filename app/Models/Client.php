<?php

namespace App\Models;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model

{

    protected $fillable = ['user_id', 'achievements'];

    public function user()

    {

        return $this->belongsTo(User::class);

    }

    public function loyaltyPoints()

    {

        return $this->hasMany(LoyaltyPoint::class);

    }

    public function payments()

    {

        return $this->hasMany(Payment::class);

    }

    public function orders()

    {

        return $this->hasMany(Order::class);

    }

    public function reviews()

    {

        return $this->hasMany(Review::class);

    }

    public function addresses()

    {

        return $this->morphMany(Address::class, 'addressable');

    }

    public function currentLoyaltyPoints()

    {

        return $this->loyaltyPoints()->latest()->first();

    }

}

