<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lat',
        'lng',
        'address',
        'f_name',
        'l_name',
        'phone',
        'country_id',
        'email',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function scopeDefault($query): void
    {
        $query->where('is_default', 1);
    }
}
