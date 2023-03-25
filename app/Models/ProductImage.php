<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

//    public function getImageAttribute($image)
//    {
//        if (!empty($image)) {
//            return asset('uploads/products') . '/' . $image;
//        }
//        return asset('defaults/user_default.png');
//    }
//
//    public function setImageAttribute($image)
//    {
//        if (is_file($image)) {
//            $imageFields = upload($image, 'products');
//            $this->attributes['image'] = $imageFields;
//        } else {
//            $this->attributes['image'] = $image;
//        }
//    }
}
