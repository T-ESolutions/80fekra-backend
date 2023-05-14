<?php
/**
 * Created by PhpStorm.
 * User: Al Mohands
 * Date: 22/05/2019
 * Time: 01:53 م
 */

namespace App\Http\Controllers\Eloquent\V1;

use App\Http\Controllers\Interfaces\V1\HelpersRepositoryInterface;
use App\Models\City;
use App\Models\Country;
use App\Models\Page;

class HelpersRepository implements HelpersRepositoryInterface
{

    public function countries($request)
    {
        $data = Country::active()->orderBy('sort_order', 'asc')
            ->get();
        return $data;
    }

    public function cities($request)
    {
        $data = City::where('country_id', $request->country_id)->active()->orderBy('sort_order', 'asc')
            ->get();
        return $data;
    }

    public function pages($request)
    {
        $data = Page::orderBy('id', 'asc')->get();
        return $data;
    }

    public function pageDetails($request)
    {
        $data = Page::where('id', $request['id'])->first();
        return $data;
    }


}
