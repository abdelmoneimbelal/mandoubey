<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {

    Route::get('governrates', 'MainController@governrates');
    Route::get('cities', 'MainController@cities');
    Route::get('delivery-method', 'MainController@deliveryMethod');
    Route::get('sections', 'MainController@sections');
    Route::get('messages', 'MainController@messages');

    Route::group(['prefix' => 'clients'], function () {

        Route::post('register', 'Clients\AuthController@register');
        Route::post('login', 'Clients\AuthController@login');
        Route::post('reset-password', 'Clients\AuthController@reset');
        Route::post('new-password', 'Clients\AuthController@password');

        Route::group(['middleware' => 'auth:client'], function () {
            Route::post('profile', 'Clients\AuthController@profile');
            Route::post('add-order', 'Clients\MainController@addOrder');
            Route::get('my-order', 'Clients\MainController@myOrder');
            Route::get('current-order', 'Clients\MainController@currentOrder');
            Route::post('logout', 'Clients\AuthController@logOut');
            Route::post('register-token', 'Clients\AuthController@registerToken');
            Route::post('remove-token', 'Clients\AuthController@removeToken');
            Route::post('connect-us', 'Clients\MainController@connectUs');
        });
    });

    Route::group(['prefix' => 'delegates'], function () {

        Route::post('register', 'Delegates\AuthController@register');
        Route::post('login', 'Delegates\AuthController@login');
        Route::post('reset-password', 'Delegates\AuthController@reset');
        Route::post('new-password', 'Delegates\AuthController@password');

        Route::group(['middleware' => 'auth:delegate'], function () {
            Route::post('profile', 'Delegates\AuthController@profile');
            Route::post('logout', 'Delegates\AuthController@logOut');
            Route::post('register-token', 'Delegates\AuthController@registerToken');
            Route::post('remove-token', 'Delegates\AuthController@removeToken');
            Route::post('accept-order', 'Delegates\MainController@acceptOrder');
            Route::post('connect-us', 'Delegates\MainController@connectUs');
            Route::get('my-order', 'Delegates\MainController@myOrders');
        });
    });
});