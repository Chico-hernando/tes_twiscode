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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('convert','Convert\ConvertController@convert');
Route::post('palindrome', 'Palindrome\PalindromeController@palindrome');

Route::get('transaksi','Transaksi\TransaksiController@getTransaksi');
Route::post('transaksi','Transaksi\TransaksiController@createTransaksi');
Route::put('transaksi/{id}','Transaksi\TransaksiController@updateTransaksi');
Route::delete('transaksi/{id}','Transaksi\TransaksiController@deleteTransaksi');

Route::get('transaksi/{id}','TransaksiDetail\TransaksiDetailController@getTransaksiDetail');
Route::post('transaksi/{id}','TransaksiDetail\TransaksiDetailController@creataTransaksiDetail');
Route::put('transaksi/{id}/detail/{idDetail}','TransaksiDetail\TransaksiDetailController@updateTransaksiDetail');
Route::delete('transaksi/{id}/detail/{idDetail}','TransaksiDetail\TransaksiDetailController@deleteTransaksiDetail');
