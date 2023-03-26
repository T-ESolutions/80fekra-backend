<?php

namespace App\Http\Controllers\Eloquent\V1\User;

use App\Http\Controllers\Interfaces\V1\User\AuthRepositoryInterface;
use App\Models\User;
use App\Models\Verfication;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;
use JWTAuth;
use TymonJWTAuthExceptionsJWTException;
use Mail;

class AuthRepository implements AuthRepositoryInterface {

    public function logIn($request){
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password']
        ];
        if (!$jwt_token = JWTAuth::attempt($credentials, ['exp' => Carbon::now()->addDays(7)->timestamp])) {
            return "phoneOrPasswordIncorrect";
        } else {
            $user = JWTAuth::user();

//            if ($user->suspend == 1) {
//                return "suspended";
//            }
//            if ($user->active == 0) {
//                return "not_active";
//            }
            $user->save();
            $user->jwt = $jwt_token;
            return $user;
        }
    }

    public function signUp($request)
    {
//        $data = array_merge($request , [
//            'user_phone' => $request['country_code'] . '' . $request['phone'],
//            'active' => 0,
//        ]);
        $user = User::create($request);
        return $this->sendCode($request['phone'], "activate");
    }

    public function sendCode($phone, $type)
    {
//        $code = rand(0000, 9999);
        $code = 1111;
        $verified = Verfication::updateOrcreate
        (
            [
                'phone' => $phone,
                'code' => $code,
                'type' => $type,
                'expired_at' => Carbon::now()->addHour()->toDateTimeString()
            ]
        );
//        Mail::to($email)->send(new SendCode($code));
        return true;
    }

    public function resendCode($request){
        $user_phone = $request['country_code'] . '' . $request['phone'];
        $user = User::where('user_phone', $user_phone)->first();
        $type = $user->active == 0 ? "activate" : "reset";
        return $this->sendCode($user_phone, $type);
    }

    public function verify($request){
        $user_phone = $request['country_code'] . '' . $request['phone'];

        $user = User::where('user_phone', $user_phone)->first();
//        if ($user->suspend == 1) {
//            return "suspended";
//        }
        if ($user->active == 0) {
//        $type = $user->active == 0 ? "activate" : "reset";
            $verfication = Verfication::where('phone', $user_phone)
                ->where('code', $request['code'])
//            ->where('type', $type)
                ->first();
            if ($verfication) {
                if (!$verfication->expired_at > Carbon::now()->toDateTimeString()) {
                    return response()->json(msg(failed(), trans('lang.codeExpired')));
                }
                $user->active = 1;
                $user->save();
                $user->jwt = JWTAuth::fromUser($user);
                return $user;
            } else {
                return false;
            }
        }else{
            $user->jwt = JWTAuth::fromUser($user);
            return $user;
        }

    }

    public function socialLogin($request)
    {
        $user = User::where('social_id', $request['social_id'])
            ->where('social_type', $request['social_type'])
            ->first();
        if ($user) {
//            $userFound->email = $request->email;
            $user->fcm_token = $request['fcm_token'];
            $user->save();
        }else{
            $user = User::create([
                'name' => isset($request['name']) ? $request['name'] : 'User'.rand(10000,99999),
                'social_id' => $request['social_id'],
                'fcm_token' => $request['fcm_token'],
                'email' => isset($request['email']) ? $request['email'] : null,
                'email_verified_at' => Carbon::now(),
                'active' => 1,
                'social_type' => $request['social_type']
            ]);
        }

        $user->jwt = JWTAuth::fromUser($user);
        return $user;

    }

    public function updateProfile($request)
    {
        $user = auth()->user();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->image = $request['image'];
        $user->phone = $request['phone'];
        $user->save();
        $user->jwt = JWTAuth::fromUser($user);
        return $user;
    }

    public function changePassword($request)
    {
        $user = auth()->user();
        if ($request['old_password']) {
            $old_password = Hash::check($request['old_password'], $user->password);
            if ($old_password != true) {
                return false;

            }
        }
        $user->password = $request['password'];
        $user->save();
        $user->jwt = JWTAuth::fromUser($user);
        return $user;
    }

}
