<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function getClient(){
        return $this->hasOne(Client::class,'client_id','id');

    }
    public function getOrders(){
        return $this->hasOne(Order::class,'order_id','id');
    }
}
