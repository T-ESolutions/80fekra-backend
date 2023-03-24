<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ofcold\NovaSortable\SortableTrait;

class Slider extends Model
{
    use HasFactory,SortableTrait;

    protected $fillable = [
        'image',
        'is_active',
        'product_id',
        'sort',
    ];


    public function scopeActive($query): void
    {
        $query->where('is_active', 1);
    }

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/sliders') . '/' . $image;
        }
        return asset('defaults/user_default.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $imageFields = upload($image, 'sliders');
            $this->attributes['image'] = $imageFields;
        } else {
            $this->attributes['image'] = $image;
        }
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
