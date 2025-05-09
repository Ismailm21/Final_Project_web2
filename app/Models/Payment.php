<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'client_id', 'amount', 'currency',
        'payment_method', 'transaction_id', 'status'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
