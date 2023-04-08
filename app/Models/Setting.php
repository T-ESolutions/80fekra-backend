<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'image',
    ];
    protected $appends = ['image_path'];


    public function getImagePathAttribute($image)
    {
        if (!empty($this->image)) {
            return asset('/storage') . '/' . $this->image;
        }
        return asset('defaults/default_image.png');
    }
}
