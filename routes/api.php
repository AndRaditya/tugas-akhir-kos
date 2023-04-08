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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();


});