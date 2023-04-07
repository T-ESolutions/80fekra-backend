<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\V1\CartRepositoryInterface;
use App\Http\Requests\V1\User\Order\CartRequest;
use App\Http\Resources\V1\User\Order\CartResource;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(CartRepositoryInterface $targetRepo)
    {
        $this->targetRepo = $targetRepo;
    }

    public function getCart(Request $request)
    {
        $cart = $this->targetRepo->getCart($request);
        $data['cart'] = CartResource::collection($cart);
        $total = 0;
        foreach ($data['cart'] as $cart) {
            $total += ($cart->product->price - ($cart->product->price * $cart->product->discount / 100)) * $cart->qty;
        }
        $data['total'] = $total;
        $data['shipping'] = 0;
        $data['discount'] = 0;
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function plusCart(Request $request, $id)
    {
        $data = $this->targetRepo->plusCart($request, $id);
        if (!$data) {
            return response()->json(msg(not_found(), trans('lang.not_found')));
        }
        $data = CartResource::make($data);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function minusCart(Request $request, $id)
    {
        $data = $this->targetRepo->minusCart($request, $id);
        if (!$data) {
            return response()->json(msg(not_found(), trans('lang.not_found')));
        }
        $data = CartResource::make($data);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function addCart(CartRequest $request)
    {
        $data = $this->targetRepo->addCart($request);
        $data = CartResource::make($data);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function deleteCart(Request $request, $id)
    {
        $data = $this->targetRepo->deleteCart($request, $id);

        return response()->json(msg(success(), trans('lang.success')));
    }
}
