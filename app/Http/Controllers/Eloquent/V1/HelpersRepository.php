<?php
/**
 * Created by PhpStorm.
 * User: Al Mohands
 * Date: 22/05/2019
 * Time: 01:53 م
 */

namespace App\Http\Controllers\Eloquent\V1;

use App\Http\Controllers\Interfaces\V1\HelpersRepositoryInterface;
use App\Models\Country;

class HelpersRepository implements HelpersRepositoryInterface
{

    public function countries($request)
    {
        $data = Country::active()->orderBy('sort_order','asc')
            ->get();
        return $data;
    }


}
