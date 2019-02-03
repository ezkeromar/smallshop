<?php

use Illuminate\Http\Request;

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

Route::group([
    'middleware' => ['cors', 'api'],
], function () {
	
	Route::post('/register', 'AuthController@register');
	Route::post('/login', 'AuthController@login');
	Route::post('/refresh', 'AuthController@refreshToken');
	
	Route::group([
        'middleware' => 'jwt.auth',
    ], function () {
		
		Route::post('/logout', 'AuthController@logout');
		Route::post('/product/store', 'ProductController@create');
		Route::post('/product/update', 'ProductController@update');
		Route::get('/product/list', 'ProductController@list');
		Route::get('/product/delete', 'ProductController@delete');
		Route::post('/cart/add', 'CartController@add');
		Route::post('/cart/remove', 'CartController@remove');
		Route::post('/cart/empty', 'CartController@empty');
		Route::post('/order/list', 'OrderController@list');
		Route::post('/order/change-status', 'OrderController@changeStatus');
		Route::post('/order/pay-now', 'OrderController@payNow');
	
	});
});