<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\V1\AddressesRepositoryInterface;
use App\Http\Controllers\Interfaces\V1\OrderRepositoryInterface;
use App\Http\Requests\V1\User\AddressRequest;
use App\Http\Requests\V1\User\Order\OrderRequest;
use App\Http\Resources\V1\User\Order\OrderResource;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    protected $targetRepo;

    public function __construct(OrderRepositoryInterface $targetRepo)
    {
        $this->targetRepo = $targetRepo;
    }

    public function placeOrder(OrderRequest $request)
    {
        $data = $this->targetRepo->placeOrder($request);
        if ($data == "cart_empty") {
            return response()->json(msg(failed(), trans('lang.cart_empty')));
        }
        return response()->json(msg(success(), trans('lang.success')));
    }

    public function myOrders(Request $request)
    {
        $data = $this->targetRepo->myOrders($request);
        $data = OrderResource::collection($data)->response()->getData(true);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function orderDetails(Request $request, $id)
    {
        $data = $this->targetRepo->orderDetails($request, $id);
        $data = OrderResource::make($data);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function deleteOrder(Request $request, $id)
    {
        $data = $this->targetRepo->cancelOrder($request, $id);
        if ($data == "not_found") {
            return response()->json(msg(not_found(), trans('lang.not_found')));
        } elseif ($data == "cannot_delete") {
            return response()->json(msg(failed(), trans('lang.cannot_delete')));
        }
        $data = OrderResource::make($data);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }


}
