<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\User\AuthController;
use App\Http\Controllers\Api\V1\User\HomeController;


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

    Route::get('/home', [HomeController::class, 'services']);

    Route::group(['middleware' => ['auth:api']], function () {
        Route::group(['prefix' => "auth"], function () {
            Route::post('/change-password', [AuthController::class, 'changePassword']);
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

