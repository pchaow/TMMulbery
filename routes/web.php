<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');


Route::group(['prefix' => 'admin'], function () {

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', "Admin\\UserController@index");
        Route::get('create', "Admin\\UserController@create");
        Route::get('{id}/edit', 'Admin\\UserController@edit');
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', "Admin\\RoleController@index");
        Route::get('create', "Admin\\RoleController@create");
        Route::get('{id}/edit', 'Admin\\RoleController@edit');
    });

});

