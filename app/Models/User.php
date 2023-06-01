<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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
        'password', 'type', 'whats_app', 'country_id', 'city_id', 'country', 'discount','email_verified_at'
    ];

    protected $appends = ['name', 'image_path'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {

            $user->email_verified_at = now();

        });
    }

    public function getImagePathAttribute($image)
    {
        if (!empty($this->image)) {
            return asset('/storage') . '/' . $this->image;
        }
        return asset('defaults/user_default.png');
    }

    public function getNameAttribute()
    {
        return $this->f_name . ' ' . $this->l_name;
    }

    public function setPasswordAttribute($password)
    {

        if (!empty($password) && request()->is('api/*')) {
            $this->attributes['password'] = bcrypt($password);
        } else {
            $this->attributes['password'] = $password;
        }
    }


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


    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

//    public function setPasswordAttribute($password)
//    {
//        if (!empty($password)) {
//            $this->attributes['password'] = bcrypt($password);
//        }
//    }


    public function userReviews()
    {
        return $this->hasMany(ProductReview::class, 'user_id');
    }

    public function userCart()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public function getJWTIdentifier()
    {
        // Implement getJWTIdentifier() method.
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // Implement getJWTCustomClaims() method.
        return [];
    }
}
