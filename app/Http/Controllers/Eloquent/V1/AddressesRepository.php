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
        $data = Address::where('user_id', JWTAuth::user()->id)
            ->orderBy('id', 'desc')
            ->paginate(Config('app.paginate'));

        return $data;
    }

    public function details($request)
    {
        $data = Address::where('user_id', JWTAuth::user()->id)->where('id', $request['id'])
            ->orderBy('id', 'desc')
            ->first();
        return $data;
    }

    public function store($request)
    {
        //check if this first address or not
        $exists_address = Address::where('user_id', JWTAuth::user()->id)->first();
        if (!$exists_address) {
            $request['is_default'] = 1;
        }
        $request['user_id'] = JWTAuth::user()->id;
        $data = Address::create($request);
        return $data;
    }

    public function update($request)
    {
        Address::where('id', $request['id'])->update($request);
        return true;
    }

    public function makeDefault($request)
    {
        //check if this first address or not
        $exists_address = Address::where('user_id', JWTAuth::user()->id)->where('id', $request['id'])->first();
        if (!$exists_address) {
            return false;
        } else {
            Address::where('user_id', JWTAuth::user()->id)->update(['is_default' => 0]);
            $exists_address->is_default = 1;
            $exists_address->save();
            return true;
        }
    }

    public function delete($request)
    {
        //check if this first address or not
        $exists_address = Address::where('user_id', JWTAuth::user()->id)->where('id', $request['id'])->first();
        if (!$exists_address) {
            return false;
        } else {
            $exists_address->delete();
            return true;
        }
    }

}
