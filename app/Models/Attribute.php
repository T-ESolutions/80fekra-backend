<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'is_active',
        'sort',
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


    public function attributeProducts()
    {
        return $this->belongsToMany(Product::class, 'product_attributes', 'product_id', 'attribute_id');
    }
}
