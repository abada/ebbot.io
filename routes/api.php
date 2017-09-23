<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register the API routes for your application as
| the routes are automatically authenticated using the API guard and
| loaded automatically by this application's RouteServiceProvider.
|
*/

Route::group([
    'middleware' => 'auth:api'
], function () {
    //
});

Route::group(['namespace' => 'Hook'], function() {
    Route::get('/hooks', 'HookController@index');
    Route::post('/hooks/{token}', 'HookController@hook');
});