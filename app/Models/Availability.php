<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    public function getdriver(){
        return $this->belongsToMany(
            Driver::class,
            "driver_availability",
            "availability_id",
            "driver_id"
        );
    }
}
