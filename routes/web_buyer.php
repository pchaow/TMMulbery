<?php

Route::get('/', "Buyer\\BuyerController@index");

Route::group(['prefix' => 'farmer'], function () {
    Route::get('/', "Buyer\\FarmerController@index");
    Route::get('create', "Buyer\\FarmerController@create");
    Route::get('{id}/edit', 'Buyer\\FarmerController@edit');
});

Route::get('/plant', "Buyer\\BuyerPlantController@index");
Route::get('/plant/create', "Buyer\\BuyerPlantController@createPlant");
Route::get("/plant/{id}/edit", "Buyer\\BuyerPlantController@editPlant");
Route::get("/plant/{id}/view", "Buyer\\BuyerPlantController@viewPlant");

Route::get('/order/{buyId}/confirm', "Buyer\\BuyerResourceController@confirm");
Route::get('/selllist', "Buyer\\BuyerResourceController@sellList");