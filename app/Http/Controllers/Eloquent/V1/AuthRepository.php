<?php

namespace App\Http\Controllers\Eloquent\V1;

use App\Http\Controllers\Interfaces\V1\AuthRepositoryInterface;
use App\Models\Address;
use App\Models\User;
use App\Models\Verfication;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;
use JWTAuth;
use TymonJWTAuthExceptionsJWTException;
use Mail;

class AuthRepository implements AuthRepositoryInterface
{

    public function logIn($request)
    {
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
            if ($user->email_verified_at == null) {
                return "email_not_verified";
            }
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
        $request['email_verified_at'] = Carbon::now();
        $user = User::create($request);
        //client stop it for now
//        return $this->sendCode($request['email'], "activate");
        return true;
    }

    public function sendCode($email, $type)
    {
//        $code = rand(0000, 9999);
        $code = 1111;
        $verified = Verfication::updateOrcreate
        (
            [
                'phone' => $email,
                'code' => $code,
                'type' => $type,
                'expired_at' => Carbon::now()->addHour()->toDateTimeString()
            ]
        );
//        Mail::to($email)->send(new SendCode($code));
        return true;
    }

    public function resendCode($request)
    {
        $user = User::where('email', $request['email'])->first();
        return $this->sendCode($request['email'], 'reset');
    }

    public function verify($request)
    {
        $user = User::where('email', $request['email'])->first();
        $verfication = Verfication::where('phone', $request['email'])
            ->where('code', $request['code'])
            ->first();
        if ($verfication) {
            if (!$verfication->expired_at > Carbon::now()->toDateTimeString()) {
                return response()->json(msg(failed(), trans('lang.codeExpired')));
            }
            $user->email_verified_at = Carbon::now();
            $user->save();
            $user->jwt = JWTAuth::fromUser($user);

            //remove verification row from DB ...
            $verfication->delete();
            return $user;
        } else {
            return false;
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
        } else {
            $user = User::create([
                'name' => isset($request['name']) ? $request['name'] : 'User' . rand(10000, 99999),
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
        User::where('id', $user->id)->update($request);
        return $user;
    }

    public function checkEmailToUpdate($request)
    {
        $user = auth()->user();
        return $this->sendCode($request['email'], "activate");
    }

    public function checkPhoneToUpdate($request)
    {
        $user = auth()->user();
        return $this->sendCode($request['phone'], "activate");
    }

    public function checkEmailCodeToUpdate($request)
    {
        $verfication = Verfication::where('phone', $request['email'])
            ->where('code', $request['code'])
            ->first();
        if ($verfication) {
            if (!$verfication->expired_at > Carbon::now()->toDateTimeString()) {
                return response()->json(msg(failed(), trans('lang.codeExpired')));
            }
            $user = auth()->user();
            $user->email = $request['email'];
            $user->save();
            $user->jwt = JWTAuth::fromUser($user);

            //remove verification row from DB ...
            $verfication->delete();
            return $user;
        } else {
            return false;
        }
    }

    public function checkPhoneCodeToUpdate($request)
    {
        $verfication = Verfication::where('phone', $request['phone'])
            ->where('code', $request['code'])
            ->first();
        if ($verfication) {
            if (!$verfication->expired_at > Carbon::now()->toDateTimeString()) {
                return response()->json(msg(failed(), trans('lang.codeExpired')));
            }
            $user = auth()->user();
            $user->phone = $request['phone'];
            $user->save();
            $user->jwt = JWTAuth::fromUser($user);

            //remove verification row from DB ...
            $verfication->delete();
            return $user;
        } else {
            return false;
        }
    }

    public function changePassword($request)
    {
        $user = auth()->user();
        if (isset($request['old_password'])) {
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
