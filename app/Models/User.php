<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'authentication_method',
        'otp_code',
        'otp_expires_at',
        'is_verified',
        'user_id', 'area_id', 'vehicle_type', 'vehicle_number',
        'pricing_model', 'rate_per_km', 'fixed_rate', 'rating'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function availabilities()
    {
        return $this->belongsToMany(Availability::class, 'driver_availability')
            ->withTimestamps();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAddresses(){
        return $this->hasOne(Address::class);
    }

    public function generateOtpCode(){
        $this->timestamps = false;
        $this->otp_code=rand(1000,9999);
        $this->otp_expires_at=now()->addMinutes(10);
        $this->save();

    }

    public function resetOtpCode()
    {
        $this->timestamps = false;
        $this->otp_code=null;
        $this->otp_expires_at=null;
        $this->save();

    }

}
