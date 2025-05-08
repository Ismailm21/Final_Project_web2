<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model

{

    protected $fillable = ['client_id', 'order_id', 'rating', 'review'];

    public function client()

    {

        return $this->belongsTo(Client::class);

    }

    public function order()

    {

        return $this->belongsTo(Order::class);

    }

}

