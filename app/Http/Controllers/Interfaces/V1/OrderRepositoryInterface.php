<?php
/**
 * Created by PhpStorm.
 * User: Al Mohands
 * Date: 22/05/2019
 * Time: 01:52 م
 */

namespace App\Http\Controllers\Interfaces\V1;


interface OrderRepositoryInterface
{

    public function placeOrder($request);
    public function myOrders($request);
    public function orderDetails($request ,$id);
    public function cancelOrder($request ,$id);

}
