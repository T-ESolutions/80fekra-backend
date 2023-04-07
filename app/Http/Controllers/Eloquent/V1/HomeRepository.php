<?php
/**
 * Created by PhpStorm.
 * User: Al Mohands
 * Date: 22/05/2019
 * Time: 01:53 م
 */

namespace App\Http\Controllers\Eloquent\V1;

use App\Http\Controllers\Interfaces\V1\HomeRepositoryInterface;
use App\Models\Slider;

class HomeRepository implements HomeRepositoryInterface
{

    public function home($request)
    {
        $data['sliders'] = Slider::active()->orderBy('sort_order','asc')->get();
        return $data;
    }


}
