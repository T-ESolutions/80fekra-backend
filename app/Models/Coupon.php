<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    const PERCENTAGE = 'percentage';
    const AMOUNT = 'amount';


    protected $fillable = [
        'code',
        'discount',
        'type',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts =[
        'start_date'=>'date',
        'end_date'=>'date',
    ];

    public function scopeActive($query): void
    {
        $query->where('is_active', 1);
    }

    public function couponUsage()
    {
        return $this->hasMany(CouponUsage::class, 'coupon_id');
    }
}
