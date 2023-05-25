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


// KOS
Route::get('landing-page/{id}', 'Api\KosController@get');

// KAMAR
Route::get('kamar-kosong', 'Api\KamarController@getKamarKosong');
Route::get('kamar-photos', 'Api\KamarController@getKamarPhotos');
Route::get('kamar-fasilitas', 'Api\KamarController@getFasilitasKamar');
Route::get('kamar-harga', 'Api\KamarController@getHargaKamar');

Route::post('forgot-password', 'Api\UserController@forgotPassword');
Route::get('forgot-password-view', 'Api\UserController@forgotPasswordView');

Route::group(['middleware' => ['auth.redis']], function () {
    
    Route::get('users/{id}', 'Api\UserController@get');
    Route::get('users', 'Api\UserController@getAll');
    Route::get('users-pengelola', 'Api\UserController@getPengelola');
    Route::put('users/{id}', 'Api\UserController@update');
    Route::put('users', 'Api\UserController@changePassword');
    Route::post('users-firebase', 'Api\UserController@getFirebaseToken');
    Route::get('logout', 'Api\UserController@logout');


    // SEND NOTIFICATION
    Route::post('users/send-notification', 'Api\NotificationController@sendNotification');


// KOS
Route::get('kos', 'Api\KosController@getAll');
Route::get('kos/{id}', 'Api\KosController@get');
Route::post('kos', 'Api\KosController@create');
Route::put('kos/{id}', 'Api\KosController@update');

    // KAMAR
    Route::get('kamar', 'Api\KamarController@getAll');
    Route::get('kamar/{id}', 'Api\KamarController@get');
    Route::get('kamar-nomor/{id}', 'Api\KamarController@getByNomor');
    Route::get('kamar-nomor', 'Api\KamarController@getNomorKamarWithNama');

    Route::post('kamar', 'Api\KamarController@create');
    Route::put('kamar/{id}', 'Api\KamarController@update');
    Route::delete('kamar/{id}', 'Api\KamarController@delete');

    Route::put('kamar-photos/{id}', 'Api\KamarController@deleteKamarPhotos');

    // KOS BOOKING
    Route::get('kos-booking', 'Api\KosBookingController@getAll');
    Route::get('kos-booking/{id}', 'Api\KosBookingController@get');
    Route::post('kos-booking', 'Api\KosBookingController@create');
    Route::put('kos-booking/{id}', 'Api\KosBookingController@update');
    Route::get('kos-booking-users/{id}', 'Api\KosBookingController@getByUser');
    Route::post('kos-booking-pembayaran/{id}', 'Api\KosBookingController@pembayaran');
    Route::delete('kos-booking/{id}', 'Api\KosBookingController@delete');


// TRANSAKSI MASUK
Route::get('transaksi-masuk', 'Api\TransaksiMasukController@getAll');
Route::get('transaksi-masuk/{id}', 'Api\TransaksiMasukController@get');
Route::post('transaksi-masuk', 'Api\TransaksiMasukController@create');
Route::put('transaksi-masuk/{id}', 'Api\TransaksiMasukController@update');
Route::delete('transaksi-masuk/{id}', 'Api\TransaksiMasukController@delete');

// TRANSAKSI KELUAR
Route::get('transaksi-keluar', 'Api\TransaksiKeluarController@getAll');
Route::get('transaksi-keluar/{id}', 'Api\TransaksiKeluarController@get');
Route::post('transaksi-keluar', 'Api\TransaksiKeluarController@create');
Route::put('transaksi-keluar/{id}', 'Api\TransaksiKeluarController@update');
Route::delete('transaksi-keluar/{id}', 'Api\TransaksiKeluarController@delete');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();


});