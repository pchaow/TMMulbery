<?php

Route::get('/', "Buyer\\BuyerController@index");

Route::group(['prefix' => 'farmer'], function () {
    Route::get('/', "Buyer\\FarmerController@index");
    Route::get('create', "Buyer\\FarmerController@create");
    Route::get('{id}/edit', 'Buyer\\FarmerController@edit');
    Route::get('{id}/profile', 'Buyer\\FarmerController@viewProfileFarmer');
});

Route::get('/plant', "Buyer\\BuyerPlantController@index");
Route::get('/plant/create', "Buyer\\BuyerPlantController@createPlant");
Route::get("/plant/{id}/edit", "Buyer\\BuyerPlantController@editPlant");
Route::get("/plant/{id}/profile", "Buyer\\BuyerPlantController@viewProfilePlant");
Route::get("/plant/{id}/view", "Buyer\\BuyerPlantController@viewPlant");

Route::get('/order/{buyId}/confirm', "Buyer\\BuyerResourceController@confirm");
Route::get('/selllist', "Buyer\\BuyerResourceController@sellList");
Route::get('/buylist', "Buyer\\BuyerResourceController@buyList");

Route::get('/plantmap', "Buyer\\BuyerController@plantMap");

Route::get('/plan',"Buyer\\BuyerController@plan");