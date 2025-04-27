<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class address extends Model
{
    protected $fillable = [''];
    public function getUsers(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
