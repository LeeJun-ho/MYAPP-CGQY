<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthControlle;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;

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

Route::post('signup', [UserController::class, 'postSignupAction']);
Route::post('login', [AuthControlle::class, 'postLoginAction']);
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthControlle::class, 'postLogoutAction']);

    Route::get('myinfo', [UserController::class, 'getMyInfoAction']);
    Route::get('myorders', [UserController::class, 'getMyOrdersAction']);
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'getCollectionAction']);
        Route::get('/{id}', [UserController::class, 'getAction']);
        Route::get('/{id}/orders', [UserController::class, 'getOrdersAction']);
    });

    Route::prefix('orders')->group(function () {
        Route::post('/', [OrderController::class, 'postAction']);
    });
});
