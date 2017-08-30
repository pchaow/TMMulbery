<?php

Route::get('/', "Farmer\\FarmerController@index");
Route::get('/plant/create', "Farmer\\FarmerController@createPlant");
Route::get("/plant/{id}/edit", "Farmer\\FarmerController@editPlant");
Route::get("/plant/{id}/view", "Farmer\\FarmerController@viewPlant");

Route::get('/plant', "Farmer\\FarmerController@plantIndex");