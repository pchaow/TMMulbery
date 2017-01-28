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

Route::group(['prefix' => 'plants'], function () {

    Route::get('/', function () {
        //show index view
        return view('admin.plant.index');
    });

    Route::get('create', function () {
        //show create view
        return view('admin.plant.create');
    });

    Route::get('{id}/edit', function ($id) {
        //show edit form
        return view('admin.plant.edit')
            ->with('plantId', $id);
    });

});