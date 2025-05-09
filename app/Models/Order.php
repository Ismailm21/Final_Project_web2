<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id', 'driver_id', 'pickup_address_id', 'dropoff_address_id',
        'payment_id', 'package_weight', 'package_size_l', 'package_size_w',
        'package_size_h', 'status', 'tracking_code'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function pickupAddress()
    {
        return $this->belongsTo(Address::class, 'pickup_address_id');
    }

    public function dropoffAddress()
    {
        return $this->belongsTo(Address::class, 'dropoff_address_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
