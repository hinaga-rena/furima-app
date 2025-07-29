<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function likedProducts()
    {
        return $this->belongsToMany(Product::class, 'likes')->withTimestamps();
    }

    public function needsProfileSetup()
    {
        return is_null($this->zip) && is_null($this->address);
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function getProfileImageUrlAttribute()
    {
        return $this->profile_image
        ? asset('storage/' . $this->profile_image)
        : asset('images/default-icon.png'); // デフォルト画像
    }
}
