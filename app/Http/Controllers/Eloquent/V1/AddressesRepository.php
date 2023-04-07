<?php
/**
 * Created by PhpStorm.
 * User: Al Mohands
 * Date: 22/05/2019
 * Time: 01:53 م
 */

namespace App\Http\Controllers\Eloquent\V1;

use App\Http\Controllers\Interfaces\V1\AddressesRepositoryInterface;
use App\Models\Address;
use App\Models\Slider;
use League\Flysystem\Config;
use JWTAuth;
use TymonJWTAuthExceptionsJWTException;

class AddressesRepository implements AddressesRepositoryInterface
{

    public function index($request)
    {
        $data['addresses'] = Address::where('user_id',JWTAuth::user()->id)->orderBy('created_at','desc')->paginate(Config('app.paginate'));
        return $data;
    }

    public function store($request)
    {

        $request['user_id'] = JWTAuth::user()->id;
        $data = Address::create($request);
        return $data;
    }

}
