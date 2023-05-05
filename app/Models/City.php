<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ofcold\NovaSortable\SortableTrait;

class City extends Model
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'title_ar', 'title_en', 'is_active', 'sort_order', 'shipping_cost', 'country_id'
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

    public function addresses()
    {
        return $this->hasMany(Address::class, 'city_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
