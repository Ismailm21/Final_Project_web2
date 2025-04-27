<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function getClient(){
        return $this->belongsTo(Client::class,'client_id','id');
    }
    public function getOrder(){
        return $this->belongsTo(Order::class);
    }
}
