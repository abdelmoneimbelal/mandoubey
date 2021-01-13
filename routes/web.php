<?php

use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

Auth::routes(['register' => false]);
//Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('delegates', 'DelegateController');
    Route::post('/status-delegates/{id}', 'DelegateController@statusUpdate')->name('status-delegates');
    Route::resource('governorates', 'GovernorateController');
    Route::resource('cities', 'CityController');
    Route::resource('delivery-method', 'DeliveryMethodController');
    Route::resource('clients', 'ClientController');
    Route::post('/status-update/{id}', 'ClientController@statusUpdate')->name('status-update');
    Route::resource('message', 'MessageController');
    Route::resource('sections', 'SectionController');
    Route::resource('shipping-price', 'ShippingPriceController');
    Route::resource('order', 'OrderController');
    Route::resource('notification', 'NotificationController');
    Route::resource('connect-us', 'ConnectUsController');
    Route::resource('roles', 'RoleController');
    Route::resource('users', 'UserController');
});
Route::get('/{page}', 'AdminController@index');