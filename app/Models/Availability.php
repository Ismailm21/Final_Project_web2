<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = ['date', 'start_time', 'end_time', 'status'];

    public function drivers()
    {
        return $this->belongsToMany(Driver::class, 'driver_availability')
            ->withTimestamps();
    }

    public function pending_drivers()
    {
        return $this->belongsToMany(Driver::class, 'pending_availability')
            ->withTimestamps();
    }
}
