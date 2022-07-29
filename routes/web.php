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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'App\Http\Controllers\Admin'], function () {

    Route::get('admin/login', 'AuthController@login')->name('admin/login');
    Route::post('doLogin', 'AuthController@doLogin')->name('doLogin');
});



Route::group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => 'auth:admin'], function () {

    Route::get('product', 'ProductsController@product')->name('product');

});
