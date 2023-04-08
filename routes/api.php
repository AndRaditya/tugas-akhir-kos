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
// Route::get('users/{id}', 'Api\UserController@get');
// Route::get('users', 'Api\UserController@getAll');


//USER
Route::post('login', 'App\Http\Controllers\Api\UserController@login');
Route::post('users', 'App\Http\Controllers\Api\UserController@create');
Route::get('users/{id}', 'App\Http\Controllers\Api\UserController@get');
Route::get('users', 'App\Http\Controllers\Api\UserController@getAll');
Route::put('users/{id}', 'App\Http\Controllers\Api\UserController@update');

// KOS
Route::get('kos', 'App\Http\Controllers\Api\KosController@getAll');
Route::get('kos/{id}', 'App\Http\Controllers\Api\KosController@get');
Route::post('kos', 'App\Http\Controllers\Api\KosController@create');
Route::put('kos/{id}', 'App\Http\Controllers\Api\KosController@update');

// KAMAR
Route::get('kamar', 'App\Http\Controllers\Api\KamarController@getAll');
Route::get('kamar/{id}', 'App\Http\Controllers\Api\KamarController@get');
Route::post('kamar', 'App\Http\Controllers\Api\KamarController@create');
Route::put('kamar/{id}', 'App\Http\Controllers\Api\KamarController@update');

// KOS BOOKING
Route::get('kos-booking', 'App\Http\Controllers\Api\KosBookingController@getAll');
Route::get('kos-booking/{id}', 'App\Http\Controllers\Api\KosBookingController@get');
Route::post('kos-booking', 'App\Http\Controllers\Api\KosBookingController@create');
Route::put('kos-booking/{id}', 'App\Http\Controllers\Api\KosBookingController@update');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();


});