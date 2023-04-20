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
    public function settings($request);
    public function setting($request,$id);

}
