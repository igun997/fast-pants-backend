<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix("auth")->namespace("App\Http\Controllers")->middleware("api")->group(function (){
    Route::post('hash', 'Authorization@hash');
    Route::post('login', 'Authorization@login');
    Route::post('logout', 'Authorization@logout');
    Route::post('refresh', 'Authorization@refresh');
    Route::post('me', 'Authorization@me');
});
Route::prefix("wooapi")->namespace("App\Http\Controllers")->middleware("auth:api")->group(function (){
    Route::get('listing', 'WooAPI@listing');
    Route::post('add', 'WooAPI@add_site');
    Route::get('products', 'WooAPI@products');
    Route::get('product/{id}/variations', 'WooAPI@product_variations');
    Route::post('order', 'WooAPI@order');
    Route::get('payments', 'WooAPI@payments');
    Route::get('current_login', 'WooAPI@current_login');
    Route::post('generate_login', 'WooAPI@generate_cookie');
    Route::get('customer/{id}', 'WooAPI@customer');
});



