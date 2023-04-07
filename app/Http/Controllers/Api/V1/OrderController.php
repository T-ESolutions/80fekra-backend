<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\V1\AddressesRepositoryInterface;
use App\Http\Controllers\Interfaces\V1\OrderRepositoryInterface;
use App\Http\Requests\V1\User\AddressRequest;
use App\Http\Requests\V1\User\Order\OrderRequest;
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

    }

}
