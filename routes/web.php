<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//LOGIN
Route::get('/', 'App\Http\Controllers\AuthController@login')->name('login');
Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('login');
Route::post('/loginProses', 'App\Http\Controllers\AuthController@loginProses');

//BACKEND
Route::group(['middleware' => 'auth'], function () {

    //DASHBOARD
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index');

    //USER
    Route::get('/user', 'App\Http\Controllers\UserController@index');
    Route::get('/data-user', 'App\Http\Controllers\UserController@data');
    Route::post('/store-user', 'App\Http\Controllers\UserController@store');
    Route::post('/update-user', 'App\Http\Controllers\UserController@update');
    Route::post('/delete-user', 'App\Http\Controllers\UserController@delete');

    //BIAYA
    Route::get('/biaya', 'App\Http\Controllers\BiayaController@index');
    Route::get('/data-biaya', 'App\Http\Controllers\BiayaController@data');
    Route::post('/store-biaya', 'App\Http\Controllers\BiayaController@store');
    Route::post('/update-biaya', 'App\Http\Controllers\BiayaController@update');
    Route::post('/delete-biaya', 'App\Http\Controllers\BiayaController@delete');

    //PROFIL USAHA
    Route::get('/profil-usaha', 'App\Http\Controllers\ProfilUsahaController@index');
    Route::get('/data-profil-usaha', 'App\Http\Controllers\ProfilUsahaController@data');
    Route::post('/store-profil-usaha', 'App\Http\Controllers\ProfilUsahaController@store');
    Route::post('/update-profil-usaha', 'App\Http\Controllers\ProfilUsahaController@update');
    Route::post('/delete-profil-usaha', 'App\Http\Controllers\ProfilUsahaController@delete');

    //TRANSAKSI
    Route::get('/transaksi', 'App\Http\Controllers\TransaksiController@index');
    Route::get('/data-transaksi', 'App\Http\Controllers\TransaksiController@data');
    Route::post('/store-transaksi', 'App\Http\Controllers\TransaksiController@store');
    Route::post('/update-transaksi', 'App\Http\Controllers\TransaksiController@update');
    Route::post('/delete-transaksi', 'App\Http\Controllers\TransaksiController@delete');
    Route::get('/export-transaksi', 'App\Http\Controllers\TransaksiController@exportPdf');

    //DETAIL TRANSAKSI
    Route::get('/detail-transaksi', 'App\Http\Controllers\DetailTransaksiController@index');
    Route::post('/store-detail-transaksi', 'App\Http\Controllers\DetailTransaksiController@store');
    Route::post('/update-detail-transaksi', 'App\Http\Controllers\DetailTransaksiController@update');
    Route::post('/update2-detail-transaksi', 'App\Http\Controllers\DetailTransaksiController@update2');
    Route::post('/delete-detail-transaksi', 'App\Http\Controllers\DetailTransaksiController@delete');

});

//LOGOUT
Route::get('/logout', function () {
    Auth::logout();
    return redirect('login');
})->name('logout');