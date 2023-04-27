<?php

namespace App\Http\Controllers\Interfaces\V1;

interface AuthRepositoryInterface{

    public function logIn($request);
    public function signUp($request);
    public function sendCode($email, $type);
    public function resendCode($request);
    public function verify($request);
    public function updateProfile($request);
    public function checkEmailToUpdate($request);
    public function checkPhoneToUpdate($request);
    public function checkEmailCodeToUpdate($request);
    public function checkPhoneCodeToUpdate($request);
    public function changePassword($request);


}
