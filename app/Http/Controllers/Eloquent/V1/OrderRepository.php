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
use App\Models\Slider;
use League\Flysystem\Config;
use JWTAuth;
use TymonJWTAuthExceptionsJWTException;

class OrderRepository implements OrderRepositoryInterface
{

    public function placeOrder($request)
    {

    }


}
