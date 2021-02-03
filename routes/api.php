<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => 'api'], function() {

    Route::get("/get_weather", "WeatherController@index");
    Route::get("/get_orders", "OrderController@show");
    Route::get("/get_order/{order_id}", "OrderController@edit");
    Route::post("/update_order/{order_id}", "OrderController@update");

});
