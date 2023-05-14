<?php
/**
 * Created by PhpStorm.
 * User: Al Mohands
 * Date: 22/05/2019
 * Time: 01:53 م
 */

namespace App\Http\Controllers\Eloquent\V1;

use App\Http\Controllers\Interfaces\V1\AddressesRepositoryInterface;
use App\Http\Controllers\Interfaces\V1\OrderRepositoryInterface;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Slider;
use Carbon\Carbon;
use League\Flysystem\Config;
use JWTAuth;
use TymonJWTAuthExceptionsJWTException;

class OrderRepository implements OrderRepositoryInterface
{

    public function placeOrder($request)
    {
        $user_id = JWTAuth::user()->id;
        $user = JWTAuth::user();
        $carts = Cart::where('user_id', JWTAuth::user()->id)->get();
        if ($carts->count() == 0) {
            return "cart_empty";
        }
        $sub_total = 0;
        foreach ($carts as $cart) {
            $sub_total += ($cart->product->price - ($cart->product->price * $cart->product->discount / 100)) * $cart->qty;
        }
        $address = Address::whereId($request->address_id)->first();
        $coupon = Coupon::where('code', $request->coupon_code)
            ->active()
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->first();


        $discount = 0;
        if ($user->discount == 0) {
            if ($coupon) {
                //check if user used coupon or not
                $exists_usage = CouponUsage::where('user_id', $user_id)->where('coupon_id', $coupon->id)->first();
                if ($exists_usage) {
                    return "coupon_used_before";
                }
                if ($coupon->type == Coupon::PERCENTAGE) {
                    $discount = $sub_total * $coupon->discount / 100;
                }

            }
        } else {

            $discount += $sub_total * $user->discount / 100;

        }
        // $total = $sub_total - $discount;

        $total = $sub_total - $discount;
        $shipping_cost = $address->country->shipping_cost;
        if ($user->shipping_free) {
            $shipping_cost = 0;
        }
        $total += $shipping_cost;
        if ($request->payment_type == Order::PAYMENT_TYPE_CASH) {
            $payment_status = Order::PAYMENT_STATUS_NOT_PAID;
        } else {
            $payment_status = Order::PAYMENT_STATUS_PAID;
        }
        $order = Order::create([
            'user_id' => $user_id,
            'address' => $address,
            'coupon' => $coupon,
            'subtotal' => $sub_total,
            'discount' => $discount,
            'shipping_cost' => $shipping_cost,
            'total' => $total,
            'payment_status' => $payment_status,
            'payment_type' => $request->payment_type,
            'status' => Order::STATUS_PENDING,
        ]);

        foreach ($carts as $cart) {
            $price = $cart->product->price - ($cart->product->price * $cart->product->discount / 100);
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'qty' => $cart->qty,
                'price' => $price,
                'total' => $price * $cart->qty,

            ]);
        }

        if ($order && $discount > 0) {
            //TODO : make coupon usage
            $coupon->usage_count = $coupon->usage_count + 1;
            $coupon->save();

            $coupon_usage_data['user_id'] = $user_id;
            $coupon_usage_data['coupon_id'] = $coupon->id;
            CouponUsage::create($coupon_usage_data);
        }

        $cart->delete();

        return $order;
    }

    public function applyCoupon($request)
    {
        $user_id = JWTAuth::user()->id;
        $carts = Cart::where('user_id', $user_id)->get();
        if ($carts->count() == 0) {
            return "cart_empty";
        }
        $sub_total = 0;
        foreach ($carts as $cart) {
            $sub_total += ($cart->product->price - ($cart->product->price * $cart->product->discount / 100)) * $cart->qty;
        }
        $coupon = Coupon::where('code', $request->coupon_code)
            ->active()
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->first();

        $discount = 0;
        if ($coupon) {
            //check if user used coupon or not
            $exists_usage = CouponUsage::where('user_id', $user_id)->where('coupon_id', $coupon->id)->first();
            if ($exists_usage) {
                return "coupon_used_before";
            }
            if ($coupon->type == Coupon::PERCENTAGE) {
                $discount = $sub_total * $coupon->discount / 100;
            } else {//amount
                $discount = 0;
            }
        }

        $result['sub_total'] = $sub_total;
        $result['discount'] = $discount;
        $result['final_total'] = $sub_total - $discount;
        return $result;
    }

    public function myOrders($request)
    {
        $order = Order::Query();
        if ($request->status == 'current') {
            $order = $order->whereIn('status', [Order::STATUS_PENDING, Order::STATUS_ON_PROGRESS, Order::STATUS_SHIPPED]);
        } elseif ($request->status == 'previous') {
            $order = $order->whereIn('status', [Order::STATUS_DELIVERED, Order::STATUS_REJECTED, Order::STATUS_CANCELLED_BY_USER, Order::STATUS_CANCELLED_BY_ADMIN]);
        } else {
            $order = $order->where('status', Order::STATUS_DELIVERED)
                ->orWhere('status', Order::STATUS_REJECTED)
                ->orWhere('status', Order::STATUS_CANCELLED_BY_USER)
                ->orWhere('status', Order::STATUS_CANCELLED_BY_ADMIN);
        }
        $order = $order->where('user_id', JWTAuth::user()->id)->orderBy('id', 'desc')->paginate(Config('app.paginate'));
        return $order;
    }

    public function orderDetails($request, $id)
    {
        $order = Order::where('user_id', JWTAuth::user()->id)
            ->where('id', $id)
            ->with('orderDetails')
            ->first();


        return $order;
    }

    public function cancelOrder($request, $id)
    {
        $order = Order::where('user_id', JWTAuth::user()->id)
            ->where('id', $id)
            ->with('orderDetails')
            ->first();

        if ($order) {
            if ($order->status == Order::STATUS_PENDING) {
                $order->status = Order::STATUS_CANCELLED_BY_USER;
                $order->save();
            } else {
                return "cannot_delete";
            }
        } else {
            return "not_found";
        }

        return $order;
    }

}
