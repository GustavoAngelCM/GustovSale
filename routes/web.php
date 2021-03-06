<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::group(['middleware' => [], 'prefix' => 'v1'], function () {
    Route::group(['middleware' => [], 'prefix' => 'sale'], function () {
        Route::post('/register', ['as' => 'register_sale', 'uses' => 'SaleController@register']);
        Route::get('/report', ['as' => 'report_sale', 'uses' => 'SaleController@report']);
    });
});