<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function getClient(){
        return $this->hasOne(Client::class,'client_id','id');
    }
    public function getPickAddress(){
        return $this->hasOne(Address::class,'pickup_address_id','id');
    }
    public function getDropAddress(){
        return $this->hasOne(Address::class,'dropOff_address_id','id');
    }
    public function getDriver(){
        return $this->hasOne(Driver::class,'driver_id','id');
    }
    public function getPayment(){
        return $this->hasMany(Payment::class,'payment_id','id');
    }
    public function getReview(){
        return $this->belongsTo(Review::class,'order_id','id');
    }
}
