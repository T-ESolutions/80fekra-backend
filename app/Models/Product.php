<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar', 'title_en', 'description_ar', 'description_en', 'is_active', 'sort_order', 'discount', 'tags'
    ];

    protected $appends = ['title', 'description'];

    public function getTitleAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->title_en;
        } else {
            return $this->title_ar;
        }
    }

    public function getDescriptionAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->description_en;
        } else {
            return $this->description_ar;
        }
    }


    public function scopeActive($query): void
    {
        $query->where('is_active', 1);
    }

    public function getTagsAttribute()
    {
        if ($this->attributes['tags'] != null) {
            return json_decode($this->attributes['tags']);
        }
        return "";
    }

    public function setTagsAttribute($tags)
    {
        if (isset($tags) && $tags != null) {
            $this->attributes['tags'] = json_encode($tags);
        }
    }

    public function productCategories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'category_id', 'product_id');
    }

    public function productAttributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes', 'attribute_id', 'product_id');
    }

    public function productImages()
    {
        $this->hasMany(ProductImage::class, 'product_id');
    }

    public function productReviews()
    {
        $this->hasMany(ProductReview::class, 'product_id');
    }

    public function productReviewsApproved()
    {
        $this->hasMany(ProductReview::class, 'product_id')->where('is_approved', 1);
    }
}
