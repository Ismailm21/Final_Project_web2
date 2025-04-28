<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Client extends User
{
    protected $table = 'Users';
    protected static function booted(): void
    {
        static::addGlobalScope('client', function (Builder $builder) {
            $builder->where('role', 'client');
        });
    }

    public function getReviews(){
        return $this->belongsTo(Review::class, 'client_id','id');
    }
    public function getLoyalties(){
        return $this->hasOne(Loyalty_point::class, );
    }
}
