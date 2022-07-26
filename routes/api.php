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
    Route::get('all_brands', 'DashboardController@allBrands');
    Route::get('all_brands/{search}', 'DashboardController@allBrands');
    Route::get('all_categories', 'DashboardController@allCategories');
    Route::get('all_categories/{search}', 'DashboardController@allCategories');
    Route::post('all_watches', 'DashboardController@allWatches');
    Route::get('watch_detail/{id}', 'DashboardController@watchDetail');
    Route::get('search/{keyword}', 'DashboardController@search');
    Route::get('topCategoryProducts', 'DashboardController@topCategoryProducts');
});



Route::group(['namespace' => 'App\Http\Controllers\Api\Ecommerce', 'middleware' => 'auth:api'], function () {

    // Route::post('addtocart', 'CartController@addToCart');
    // Route::post('updatecart', 'CartController@updateCart');
    // Route::post('removecart', 'CartController@removeFromCart');
    Route::post('add_card', 'PaymentMethodController@addPaymentMethod');
    Route::get('show_cards', 'PaymentMethodController@showMethod');
    Route::post('delete_cards', 'PaymentMethodController@deleteMethod');
    Route::post('addToWishlist', 'WishlistController@addToWishlist');
    Route::get('getUserWishlist', 'WishlistController@getUserWishlist');
});
