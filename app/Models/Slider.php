<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ofcold\NovaSortable\SortableTrait;

class Slider extends Model
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'image',
        'is_active',
        'url',
        'product_id',
        'sort_order',
    ];

    protected $appends = ['image_path'];

    public function scopeActive($query): void
    {
        $query->where('is_active', 1);
    }


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


    public function getImagePathAttribute($image)
    {
        if (!empty($this->image)) {
            return asset('/storage') . '/' . $this->image;
        }
        return asset('defaults/default_image.png');
    }
}
