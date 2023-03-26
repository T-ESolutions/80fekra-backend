<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResources;
use App\Mail\SendCode;
use App\Models\ContactUs;
use App\Models\User;
use App\Models\Verfication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use JWTAuth;
use TymonJWTAuthExceptionsJWTException;
use Mail;

class UserController extends Controller
{


    public function addSuggestion(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'message' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }
        $data['writer_type'] = User::class;
        $data['writer_id'] = auth('api')->user()->id;
        ContactUs::create($data);
        return response()->json(msg(success(), trans('lang.added_s')));

    }


}
