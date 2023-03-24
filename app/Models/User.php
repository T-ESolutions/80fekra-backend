<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ADMIN = 'admin';
    const USER = 'user';
    const EMPLOYEE = 'employee';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'f_name', 'l_name', 'email', 'image', 'is_active', 'email_verified_at', 'phone',
        'password', 'type', 'whats_app', 'country_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function addresses()
    {
        $this->hasMany(Address::class, 'user_id');
    }

    public function orders()
    {
        $this->hasMany(Order::class, 'user_id');
    }

    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/users') . '/' . $image;
        }
        return asset('defaults/user_default.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $imageFields = upload($image, 'users');
            $this->attributes['image'] = $imageFields;
        } else {
            $this->attributes['image'] = $image;
        }
    }


    public function userReviews()
    {
        return $this->hasMany(ProductReview::class, 'user_id');
    }

    public function userCart()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }
}
