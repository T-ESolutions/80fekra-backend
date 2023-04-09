<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ofcold\NovaSortable\SortableTrait;

class Category extends Model
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'title_ar', 'title_en', 'image', 'is_active', 'sort_order', 'country_id'
    ];

    protected $appends = ['title','image_path'];

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

    public function getImagePathAttribute($image)
    {
        if (!empty($this->image)) {
            return asset('/storage') . '/' . $this->image;
        }
        return asset('defaults/default_image.png');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'country_id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'country_id')->with('childrenCategories');
    }


    public function categoryProducts()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'product_id', 'category_id');
    }
}
