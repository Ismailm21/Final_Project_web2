<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingDriver extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'license_number', 'vehicle_details','pricing_model', 'rate_per_km', 'fixed_rate'];

}
