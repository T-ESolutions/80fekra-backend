<?php

namespace App\Http\Controllers\Eloquent\V1;

use App\Http\Controllers\Interfaces\V1\AddressesRepositoryInterface;
use App\Http\Controllers\Interfaces\V1\CartRepositoryInterface;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Slider;
use League\Flysystem\Config;
use JWTAuth;
use TymonJWTAuthExceptionsJWTException;

class CartRepository implements CartRepositoryInterface
{

    public function getCart($request)
    {
        $data = Cart::where('user_id', JWTAuth::user()->id)->with('product')->orderBy('id', 'desc')->get();
        return $data;
    }

    public function plusCart($request, $id)
    {
        $data = Cart::where('id', $id)->first();
        if ($data) {
            $data->qty += 1;
            $data->save();
        }
        return $data;
    }

    public function minusCart($request, $id)
    {
        $data = Cart::where('id', $id)->first();

        if ($data && $data->qty > 1) {
            $data->qty -= 1;
            $data->save();
        }
        return $data;
    }

    public function deleteCart($request, $id)
    {
        $data = Cart::where('id', $id)->first();

        if ($data) {
            $data->delete();
        }
        return $data;
    }

    public function addCart($request)
    {
        $data = Cart::where('user_id', JWTAuth::user()->id)
            ->where('product_id', $request->product_id)
            ->first();
        if ($data) {
            $data->qty += $request->qty;
            $data->save();
        } else {
            $data = Cart::create([
                'user_id' => JWTAuth::user()->id,
                'product_id' => $request->product_id,
                'qty' => $request->qty,
            ]);
        }
        return $data;
    }

}
