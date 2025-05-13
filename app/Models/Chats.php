<?php



namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    protected $guarded=['id'];

    // Relationship with users (sender and receiver)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // Relationship with orders
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
