<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\HelpersController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => "v1", 'namespace' => 'V1'], function () {
    Route::group(['prefix' => "auth"], function () {
        //auth
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/sign-up', [AuthController::class, 'signUp']);
        Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
        Route::post('/verify', [AuthController::class, 'verify']);
        Route::post('/resend-code', [AuthController::class, 'resendCode']);
    });

    Route::get('/home', [HomeController::class, 'home']);
    Route::get('/helpers/countries', [HelpersController::class, 'countries']);

    Route::group(['prefix' => "helpers"], function () {
        Route::get('/countries', [HelpersController::class, 'countries']);
    });

    Route::group(['middleware' => ['auth:api']], function () {
        Route::group(['prefix' => "auth"], function () {
            Route::get('/logout', [AuthController::class, 'logout']);

            Route::post('/change-password', [AuthController::class, 'changePassword']);
            Route::get('/profile', [AuthController::class, 'profile']);
            Route::post('/update-profile', [AuthController::class, 'updateProfile']);
            Route::post('/check_location', [AuthController::class, 'check_location']);
        });
        Route::group(['prefix' => "user"], function () {
            //home
            Route::group(['prefix' => "home"], function () {
            });

        });

    });


    });

