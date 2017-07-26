<?php

Route::get('/', "Buyer\\BuyerController@index");

Route::get('/plant', "Buyer\\BuyerPlantController@index");


Route::get('/order/{buyId}/confirm', "Buyer\\BuyerResourceController@confirm");
Route::get('/selllist', "Buyer\\BuyerResourceController@sellList");