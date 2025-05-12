<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    protected $fillable = ['client_id', 'points'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
