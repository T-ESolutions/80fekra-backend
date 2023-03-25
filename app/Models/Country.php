<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ofcold\NovaSortable\SortableTrait;

class Country extends Model
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'title_ar', 'title_en', 'is_active', 'sort_order', 'shipping_cost'
    ];
    protected $appends = ['title'];

    public function getTitleAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->title_en;
        } else {
            return $this->title_ar;
        }
    }


    public function scopeActive($query): void
    {
        $query->where('is_active', 1);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'country_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'country_id');
    }
}
