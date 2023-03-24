<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar', 'title_en', 'image', 'is_active', 'sort', 'country_id'
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

//    public function getImageAttribute($image)
//    {
//        if (!empty($image)) {
//            return asset('uploads/categories') . '/' . $image;
//        }
//        return asset('defaults/user_default.png');
//    }
//
//    public function setImageAttribute($image)
//    {
//        if (is_file($image)) {
//            $imageFields = upload($image, 'categories');
//            $this->attributes['image'] = $imageFields;
//        } else {
//            $this->attributes['image'] = $image;
//        }
//    }

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
