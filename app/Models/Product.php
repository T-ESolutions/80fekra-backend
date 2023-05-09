<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

//    use \Spatie\Tags\HasTags;

    protected $fillable = [
        'title_ar', 'title_en', 'description_ar', 'description_en', 'is_active', 'sort_order', 'priceprice', 'discount', 'tags', 'attributes_ar', 'attributes_en',
        'video_url', 'short_desc_ar', 'short_desc_en'
    ];

    protected $appends = ['title', 'description', 'attributes', 'rate', 'short_description'];


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

    public function getShortDescriptionAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->short_desc_en;
        } else {
            return $this->short_desc_ar;
        }
    }

    public function getAttributesAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->attributes_en;
        } else {
            return $this->attributes_ar;
        }
    }

    public function scopeActive($query): void
    {
        $query->where('is_active', 1);
    }

    public function scopeHome($query): void
    {
        $query->where('is_home', 1);
    }


    public function getTagsAttribute()
    {

        return json_decode($this->attributes['tags']);


    }

//
    public function setTagsAttribute($tags)
    {
//        $tags_string = implode(" ",$tags) ;
//        $this->attributes['tags']  = $tags_string;

//
        if (isset($tags) && $tags != null) {
            $this->attributes['tags'] = json_encode($tags);
        }
    }

    public function productCategories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');

    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function categories()
    {
        return $this->hasMany(ProductCategory::class, 'product_id');
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }

    public function productReviewsApproved()
    {
        return $this->hasMany(ProductReview::class, 'product_id')->where('is_approved', 1);
    }

    public function getRateAttribute()
    {
        $review_count = $this->productReviewsApproved->count();
        $review_sum = $this->productReviewsApproved->sum('rate');
        if ($review_count == 0) {
            return 0;
        } else {
            return $review_sum / $review_count;
        }
    }


}
