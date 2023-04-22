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
Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@create');
Route::get('users/{id}', 'Api\UserController@get');
Route::get('users', 'Api\UserController@getAll');
Route::get('users-pengelola', 'Api\UserController@getPengelola');
Route::put('users/{id}', 'Api\UserController@update');
Route::put('users', 'Api\UserController@changePassword');

// KOS
Route::get('kos', 'Api\KosController@getAll');
Route::get('kos/{id}', 'Api\KosController@get');
Route::post('kos', 'Api\KosController@create');
Route::put('kos/{id}', 'Api\KosController@update');

// KAMAR
Route::get('kamar', 'Api\KamarController@getAll');
Route::get('kamar/{id}', 'Api\KamarController@get');
Route::get('kamar-kosong', 'Api\KamarController@getKamarKosong');
Route::post('kamar', 'Api\KamarController@create');
Route::put('kamar/{id}', 'Api\KamarController@update');

// KOS BOOKING
Route::get('kos-booking', 'Api\KosBookingController@getAll');
Route::get('kos-booking/{id}', 'Api\KosBookingController@get');
Route::post('kos-booking', 'Api\KosBookingController@create');
Route::put('kos-booking/{id}', 'Api\KosBookingController@update');
Route::get('kos-booking-users/{id}', 'Api\KosBookingController@getByUser');
Route::put('kos-booking-pembayaran/{id}', 'Api\KosBookingController@pembayaran');

// TRANSAKSI MASUK
Route::get('transaksi-masuk', 'Api\TransaksiMasukController@getAll');
Route::get('transaksi-masuk/{id}', 'Api\TransaksiMasukController@get');
Route::post('transaksi-masuk', 'Api\TransaksiMasukController@create');
Route::put('transaksi-masuk/{id}', 'Api\TransaksiMasukController@update');

// TRANSAKSI KELUAR
Route::get('transaksi-keluar', 'Api\TransaksiKeluarController@getAll');
Route::get('transaksi-keluar/{id}', 'Api\TransaksiKeluarController@get');
Route::post('transaksi-keluar', 'Api\TransaksiKeluarController@create');
Route::put('transaksi-keluar/{id}', 'Api\TransaksiKeluarController@update');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();


});