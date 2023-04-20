<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar', 'title_en', 'body_ar', 'body_en', 'image'
    ];

    protected $appends = ['title', 'body', 'image_path'];

    public function getTitleAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->title_en;
        } else {
            return $this->title_ar;
        }
    }

    public function getBodyAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->body_en;
        } else {
            return $this->body_ar;
        }
    }

    public function getImagePathAttribute($image)
    {
        if (!empty($this->image)) {
            return asset('/storage') . '/' . $this->image;
        }
        return asset('defaults/default_image.png');
    }

}
