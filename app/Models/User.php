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



    public function driver()
    {
        return $this->hasOne(Driver::class); // One user can be a driver
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'authentication_method',
        'otp_code',
        'otp_expires_at',
        'phone',
        'password',
        'role',
        'profile_img_path',
    ];

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

    // User.php
    public function client()
    {
        return $this->hasOne(Client::class);
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
