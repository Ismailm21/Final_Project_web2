<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class driver extends User
{
    protected $table = 'Users';
    protected static function booted(): void
    {
        static::addGlobalScope('driver', function (Builder $builder) {
            $builder->where('role', 'driver');
        });
    }
    public function getAddresses(){
        return $this->belonsToMany(Availability::class,'driver_id','availability_id');
    }
    public function getAvailability(){
        return $this->belongsToMany(
            Driver::class,
            "driver_availability",
            "driver_id",
            "availability_id"
        );
    }
    public function getArea(){
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }
}
