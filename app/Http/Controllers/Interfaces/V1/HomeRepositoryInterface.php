<?php
/**
 * Created by PhpStorm.
 * User: Al Mohands
 * Date: 22/05/2019
 * Time: 01:52 م
 */

namespace App\Http\Controllers\Interfaces\V1;


interface HomeRepositoryInterface
{
    public function home($request);
    public function productDetails($request);
    public function productByCategory($request);
    public function AddReview($request);
    public function settings($request);

}
