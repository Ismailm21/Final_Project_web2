<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends User
{
    // Assuming you use the same table for users, otherwise specify your clients table
    protected $table = 'clients';



    protected static function booted(): void
    {
        static::addGlobalScope('client', function (Builder $builder) {
            // Ensure clients are filtered by role 'client'
            $builder->where('role', 'client');
        });
    }


    public function getReviews()
    {
        return $this->belongsTo(Review::class, 'client_id', 'id');
    }

    /**
     * Relationship: A client has one loyalty point.
     */
    public function getLoyalties(): HasOne
    {
        return $this->hasOne(Loyalty_point::class, 'client_id', 'id');  // Specify foreign key here
    }

}
