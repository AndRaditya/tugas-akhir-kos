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


//USER
Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@create');

// KOS
Route::get('landing-page/{id}', 'Api\KosController@get');

// KAMAR
Route::get('kamar-kosong', 'Api\KamarController@getKamarKosong');
Route::get('kamar-photos', 'Api\KamarController@getKamarPhotos');
Route::get('kamar-fasilitas', 'Api\KamarController@getFasilitasKamar');

Route::get('generate-pdf', 'Api\DocumentPdfController@generatePDF');

Route::group(['middleware' => ['auth.redis']], function () {
    
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
    Route::put('kos-photos/{id}', 'Api\KosController@deleteKosPhotos');
    Route::get('kos-photos', 'Api\KosController@getPhotos');

    Route::get('kos-list', 'Api\KosController@getDataList');


    // KAMAR
    Route::get('kamar', 'Api\KamarController@getAll');
    Route::get('kamar/{id}', 'Api\KamarController@get');

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

    Route::get('kos-booking-status/user/{id}', 'Api\KosBookingController@getByStatusByUser');
    Route::get('search/kos-booking', 'Api\KosBookingController@searchPaginate');
    Route::post('filter/kos-booking', 'Api\KosBookingController@getFilter');
    Route::post('sort/kos-booking', 'Api\KosBookingController@getSortData');

    // TRANSAKSI MASUK
    Route::get('transaksi-masuk', 'Api\TransaksiMasukController@getAll');
    Route::get('transaksi-masuk/{id}', 'Api\TransaksiMasukController@get');
    Route::post('transaksi-masuk', 'Api\TransaksiMasukController@create');
    Route::put('transaksi-masuk/{id}', 'Api\TransaksiMasukController@update');
    Route::delete('transaksi-masuk/{id}', 'Api\TransaksiMasukController@delete');

    Route::put('transaksi-masuk-photos/{id}', 'Api\TransaksiMasukController@deleteBuktiTransfer');

    Route::get('transaksi-masuk-kategori', 'Api\TransaksiMasukKategoriController@getDataList');

    // TRANSAKSI KELUAR
    Route::get('transaksi-keluar', 'Api\TransaksiKeluarController@getAll');
    Route::get('transaksi-keluar/{id}', 'Api\TransaksiKeluarController@get');
    Route::post('transaksi-keluar', 'Api\TransaksiKeluarController@create');
    Route::put('transaksi-keluar/{id}', 'Api\TransaksiKeluarController@update');
    Route::delete('transaksi-keluar/{id}', 'Api\TransaksiKeluarController@delete');

    Route::get('transaksi-keluar-kategori', 'Api\TransaksiKeluarKategoriController@getDataList');

    // KOS FASILITAS
    Route::get('kos-fasilitas', 'Api\KosFasilitasController@getAll');
});

// Route::get('trs-generate-pdf', 'Api\TransaksiMasukExportController@generatePDF');

// EXPORT
Route::get('export/transaksi-masuk', 'Api\TransaksiMasukExportController@generatePDF');
Route::get('export/transaksi-keluar', 'Api\TransaksiKeluarExportController@generatePDF');
Route::get('export/transaksi-semua', 'Api\TransaksiAllExportController@generatePDF');