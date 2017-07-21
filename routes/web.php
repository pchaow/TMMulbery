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
    if (Auth::user()) {
        return redirect('/home');
    }
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/profile/{id}', 'ProfileController@viewProfileByUserId');


Route::group(["prefix" => "farmer"], function () {

    Route::get('/plant/create', "Farmer\\FarmerController@createPlant");
    Route::get("/plant/{id}/edit", "Farmer\\FarmerController@editPlant");
    Route::get("/plant/{id}/view", "Farmer\\FarmerController@viewPlant");
});


Route::group(["prefix" => "buyer"], function () {
    Route::get('/order/{buyId}/confirm', "Buyer\\BuyerResourceController@confirm");
    Route::get('/selllist', "Buyer\\BuyerResourceController@sellList");

});