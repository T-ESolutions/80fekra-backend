<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'attribute_id',
        'option',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function attributee()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
