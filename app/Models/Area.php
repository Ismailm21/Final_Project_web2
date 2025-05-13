<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name','latitude', 'longitude'];
    public function getDriver(){
        return $this->hasMany(Driver::class);
    }
}
