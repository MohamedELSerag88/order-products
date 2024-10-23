<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group([
    'prefix' => 'v1',
    'namespace' => 'V1'
], function ($router) {
    Route::post('login', 'Auth\AuthController@login');
    Route::post('register', 'Auth\AuthController@register');
    Route::group([
        'middleware' => 'auth:sanctum'
    ], function ($router) {
        Route::apiResource("products", "Product\ProductController")->only(["index","store","update"]);
        Route::apiResource("orders", "Order\OrderController")->only(["index","store","show"]);
    });
});
