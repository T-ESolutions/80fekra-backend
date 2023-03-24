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

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/settings') . '/' . $image;
        }
        return asset('defaults/user_default.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $imageFields = upload($image, 'settings');
            $this->attributes['image'] = $imageFields;
        } else {
            $this->attributes['image'] = $image;
        }
    }
}
