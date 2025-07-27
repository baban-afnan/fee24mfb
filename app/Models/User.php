<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Wallet;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_no',
        'bvn',
        'nin',
        'address',
        'photo',
        'profile_photo_url', // this stores the full path like "profile_photos/abc.jpg"
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id');
    }

    /**
     * Accessor for profile_photo_url
     * This returns a full URL like http://127.0.0.1:8000/storage/profile_photos/abc.jpg
     */
   public function getPhotoAttribute()
{
    return $this->profile_photo_url
        ? asset('storage/' . ltrim($this->profile_photo_url, '/'))
        : asset('assets/images/user/default.jpg');
}


}
