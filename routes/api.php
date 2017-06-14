<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::resource('thailand/province', "API\\ProvinceController");
Route::resource('thailand/province.amphure', "API\\ProvinceAmphureController");
Route::resource('thailand/province.amphure.district', "API\\ProvinceAmphureDistrictController");

Route::group(["prefix" => 'admin'], function () {

    Route::resource('farmer', "API\\Admin\\FarmerResourceController");
    Route::resource('farmer.plant', "API\\Admin\\FarmerPlantResourceController");
    Route::resource('user', "API\\Admin\\UserResourceController");
    Route::resource('role', "Api\\Admin\\RoleResourceController");
    Route::resource('plant', "API\\Admin\\PlantResourceController");
    Route::resource('plant_transaction_status', "API\\Admin\\PlantTransactionStatusController");

    Route::get('dashboard/sum_users_by_type', "API\\Admin\\DashboardController@sum_users_by_type");

});