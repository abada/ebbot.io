<?php

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for pages that
| are to be accessible to the public (such as documentation & legal documents)
|
*/

Route::get('/', 'WelcomeController@show');


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => 'auth'], function() {
    
    Route::get('/home', 'HomeController@show');
    
    Route::group(['namespace' => 'EbEnvironment'], function() {
       
       Route::get('/eb-environments', 'EbEnvironmentController@index');
       Route::get('/eb-environments/{id}', 'EbEnvironmentController@show');
       Route::get('/eb-environments/{id}/settings', 'EbEnvironmentController@edit');
        
    });

});
