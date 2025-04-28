<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [''];
    public function getUsers(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
