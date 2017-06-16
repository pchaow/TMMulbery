<?php


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


Route::group(['prefix' => 'plant_transaction_status'], function () {
    Route::get('/', "Admin\\PlantTransactionStatusController@index");
    Route::get('create', "Admin\\PlantTransactionStatusController@create");
    Route::get('{id}/edit', 'Admin\\PlantTransactionStatusController@edit');
});

Route::group(['prefix' => 'farmers'], function () {
    Route::get('/', "Admin\\FarmerController@index");
    Route::get('create', "Admin\\FarmerController@create");
    Route::get('{id}/edit', 'Admin\\FarmerController@edit');
    Route::get('{id}/view', 'Admin\\FarmerController@view');

    Route::get('{id}/plant/create', "Admin\\FarmerPlantController@create");
    Route::get('{id}/plant/{pid}/edit', "Admin\\FarmerPlantController@edit");
});

Route::group(['prefix' => 'plants'], function () {

    Route::get('/', 'Admin\\PlantController@index');
    Route::get('create', 'Admin\\PlantController@create');
    Route::get('{id}/edit', 'Admin\\PlantController@edit');
    Route::get('{id}/view', 'Admin\\PlantController@view');
});