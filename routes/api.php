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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::group(['namespace' => 'App\Http\Controllers\Api\Ecommerce'], function () {

    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('sendForgotPasswordEmail', 'AuthController@sendForgotPasswordEmail');
    Route::post('verifyForgotPin', 'AuthController@verifyForgotPin');
    Route::post('resetPassword', 'AuthController@resetPassword');

    Route::get('dashboard', 'DashboardController@dashBoard');
});



Route::group(['namespace' => 'App\Http\Controllers\Api\Ecommerce', 'middleware' => 'auth:api'], function () {

    Route::post('addToWishlist', 'WishlistController@addToWishlist');

});
