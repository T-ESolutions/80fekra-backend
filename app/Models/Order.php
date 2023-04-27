<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    const  PAYMENT_STATUS_PAID = "paid";
    const  PAYMENT_STATUS_NOT_PAID = "not_paid";

    const  PAYMENT_TYPE_CASH = "cash";
    const  PAYMENT_TYPE_VISA = "visa";


    const  STATUS_PENDING = "pending";
    const  STATUS_ON_PROGRESS = "on_progress";
    const  STATUS_SHIPPED = "shipped";

    const  STATUS_DELIVERED = "delivered";
    const  STATUS_REJECTED = "rejected";
    const  STATUS_CANCELLED_BY_USER = "canceled_by_user";
    const  STATUS_CANCELLED_BY_ADMIN = "canceled_by_admin";


    protected $fillable = [
        'user_id',
        'address',
        'coupon',
        'subtotal',
        'discount',
        'shipping_cost',
        'total',
        'payment_status',
        'payment_type',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function getAddressAttribute($value)
    {
        if ($value != null ) {
            return json_decode($value);
        }
        return "";

    }
//
    public function setAddressAttribute($address)
    {
        if (isset($address) && $address != null) {
            $this->attributes['address'] = json_encode($address);
        }
    }

    public function getCouponAttribute()
    {
        if ($this->attributes['coupon'] != null) {
            return json_decode($this->attributes['coupon']);
        }
        return "";
    }

    public function setCouponAttribute($coupon)
    {
        if (isset($coupon) && $coupon != null) {
            $this->attributes['coupon'] = json_encode($coupon);
        }
    }



}
