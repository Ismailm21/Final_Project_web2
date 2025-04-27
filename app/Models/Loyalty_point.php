<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loyalty_point extends Model
{
    public function getClients(){
        return $this->belongsTo(Client::class,'client_id','id');
    }
}
