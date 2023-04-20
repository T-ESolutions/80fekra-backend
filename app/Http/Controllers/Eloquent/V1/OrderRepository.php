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
        if ($coupon) {
            if ($coupon->type == Coupon::PERCENTAGE) {
                $discount = $sub_total * $coupon->discount / 100;
            } else {//amount
                $discount = 0;
            }
        }
        if ($request->payment_type == Order::PAYMENT_TYPE_CASH) {
            $payment_status = Order::PAYMENT_STATUS_NOT_PAID;
        } else {
            $payment_status = Order::PAYMENT_STATUS_PAID;
        }
        $order = Order::create([
            'user_id' => JWTAuth::user()->id,
            'address' => $address,
            'coupon' => $coupon,
            'subtotal' => $sub_total,
            'discount' => $discount,
            'shipping_cost' => $address->country->shipping_cost,
            'total' => $sub_total + $address->country->shipping_cost - $discount,
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

        $cart->delete();

        return $order;
    }

    public function myOrders($request)
    {
        $order = Order::where('user_id', JWTAuth::user()->id)
            ->orderBy('id', 'desc');
        if ($request->status == 'current') {
            $order->where('status', Order::STATUS_PENDING)
                ->orWhere('status', Order::STATUS_ON_PROGRESS)
                ->orWhere('status', Order::STATUS_SHIPPED);
        } else {
            $order->where('status', Order::STATUS_DELIVERED)
                ->orWhere('status', Order::STATUS_REJECTED)
                ->orWhere('status', Order::STATUS_CANCELLED_BY_USER)
                ->orWhere('status', Order::STATUS_CANCELLED_BY_ADMIN);
        }

        $order->paginate(Config('app.paginate'));

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
