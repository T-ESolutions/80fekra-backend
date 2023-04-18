<?php

use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\HelpersController;
use App\Http\Controllers\Api\V1\AddressesController;
use App\Http\Controllers\Api\V1\ProductController;


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
    Route::get('/settings', [HomeController::class, 'settings']);
    Route::get('/helpers/countries', [HelpersController::class, 'countries']);

    Route::group(['prefix' => "helpers"], function () {
        Route::get('/countries', [HelpersController::class, 'countries']);
        Route::get('/pages', [HelpersController::class, 'pages']);
        Route::get('/page/details', [HelpersController::class, 'pageDetails']);

    });
    Route::group(['prefix' => "product"], function () {
        Route::get('/details', [ProductController::class, 'productDetails']);
        Route::get('/related', [ProductController::class, 'productRelated']);
        Route::get('/by-category', [ProductController::class, 'productByCategory']);
    });

    Route::group(['middleware' => ['auth:api']], function () {
        Route::group(['prefix' => "auth"], function () {
            Route::get('/logout', [AuthController::class, 'logout']);
            Route::post('/change-password', [AuthController::class, 'changePassword']);
            Route::get('/profile', [AuthController::class, 'profile']);
            Route::post('/update-profile', [AuthController::class, 'updateProfile']);
            Route::post('/update-profile/check/email', [AuthController::class, 'checkEmailToUpdate']);
            Route::post('/check_location', [AuthController::class, 'check_location']);
        });
        Route::group(['prefix' => "addresses"], function () {
            //addresses
            Route::get('/', [AddressesController::class, 'index']);
            Route::post('/store', [AddressesController::class, 'store']);
            Route::post('/update', [AddressesController::class, 'update'])->name('addresses.update');
            Route::post('/make-default', [AddressesController::class, 'makeDefault']);
            Route::post('/delete', [AddressesController::class, 'delete']);
        });
        Route::group(['prefix' => "product"], function () {
            Route::post('/add-review', [ProductController::class, 'AddReview']);
        });
        Route::group(['prefix' => "cart"], function () {
            Route::get('/get-cart', [CartController::class, 'getCart']);
            Route::post('/add-cart', [CartController::class, 'addCart']);
            Route::get('/plus-cart/{id}', [CartController::class, 'plusCart']);
            Route::get('/minus-cart/{id}', [CartController::class, 'minusCart']);
            Route::get('/delete-cart/{id}', [CartController::class, 'deleteCart']);
        });
        Route::group(['prefix' => "order"], function () {
            Route::post('/place-order', [OrderController::class, 'placeOrder']);
            Route::get('/my-orders', [OrderController::class, 'myOrders']);
            Route::get('/order-details/{id}', [OrderController::class, 'orderDetails']);
            Route::get('/delete-order/{id}', [OrderController::class, 'deleteOrder']);
        });

    });


});

