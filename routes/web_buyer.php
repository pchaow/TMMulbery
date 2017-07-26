<?php

Route::get('/', "Buyer\\BuyerController@index");

Route::get('/plant', "Buyer\\BuyerPlantController@index");
Route::get('/plant/create', "Buyer\\BuyerPlantController@createPlant");
Route::get("/plant/{id}/edit", "Buyer\\BuyerPlantController@editPlant");
Route::get("/plant/{id}/view", "Buyer\\BuyerPlantController@viewPlant");

Route::get('/order/{buyId}/confirm', "Buyer\\BuyerResourceController@confirm");
Route::get('/selllist', "Buyer\\BuyerResourceController@sellList");