<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{   //lilooo
    protected $fillable = ['client_id', 'points'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
