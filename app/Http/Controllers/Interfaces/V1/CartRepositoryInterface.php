<?php
/**
 * Created by PhpStorm.
 * User: Al Mohands
 * Date: 22/05/2019
 * Time: 01:52 م
 */

namespace App\Http\Controllers\Interfaces\V1;


interface CartRepositoryInterface
{

    public function getCart($request);
    public function addCart($request);
    public function plusCart($request,$id);
    public function minusCart($request,$id);
    public function deleteCart($request,$id);

}
