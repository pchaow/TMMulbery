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

Route::group(["prefix" => 'admin', "middleware" => "auth:api"], function () {

    Route::resource('farmer', "API\\Admin\\FarmerResourceController");
    Route::get("farmer/{id}/order", "API\\Admin\\FarmerResourceController@getOrders");
    Route::resource('farmer.plant', "API\\Admin\\FarmerPlantResourceController");
    Route::resource('user', "API\\Admin\\UserResourceController");
    Route::resource('role', "Api\\Admin\\RoleResourceController");

    Route::resource('buyer', "API\\Admin\\BuyerResourceController");
    Route::get("buyer/{id}/order", "API\\Admin\\BuyerResourceController@getOrders");


    Route::resource('plant_transaction_status', "API\\Admin\\PlantTransactionStatusController");


    Route::get('dashboard/sum_users_by_type', "API\\Admin\\DashboardController@sum_users_by_type");


    Route::resource('plant', "API\\Admin\\PlantResourceController");
    Route::get("plant/{plantId}/balance", "API\\Admin\\PlantResourceController@balance");


    Route::resource('plant.transaction', "API\\Admin\\PlantTransactionController");
    Route::post("plant/{plantId}/transaction/initialFarm", "API\\Admin\\PlantTransactionController@initialFarm");
    Route::post("plant/{plantId}/transaction/harvestFarm", "API\\Admin\\PlantTransactionController@harvestFarm");


});

Route::group(["prefix" => 'farmer', "middleware" => "auth:api"], function () {
    Route::get("/", "API\\Farmer\\FarmerResourceController@index");

    Route::resource('/plant', "API\\Farmer\\FarmerPlantResourceController");

    Route::resource('/plant.transaction', "API\\Admin\\PlantTransactionController");

    Route::post("/plant/{plantId}/transaction/initialFarm", "API\\Admin\\PlantTransactionController@initialFarm");
    Route::post("/plant/{plantId}/transaction/harvestFarm", "API\\Admin\\PlantTransactionController@harvestFarm");

    Route::get("/order", "API\\Farmer\\FarmerResourceController@getOrders");
    Route::post('/order/{id}/close', "API\\Farmer\\FarmerResourceController@closeSellOrder");
    Route::post("/plant/{plantId}/open/sell", "API\\Farmer\\FarmerResourceController@createSellOrder");


});


Route::group(["prefix" => 'buyer', "middleware" => "auth:api"], function () {

    Route::resource('/', 'API\\Buyer\\BuyerController');

    Route::resource('/order', 'API\\Buyer\\OrderResourceController');

    Route::post('/order/loadSellOpenOrder', 'API\\Buyer\\OrderResourceController@loadSellOpenOrder');
    Route::post('/order/loadBuyHistoryOrder', 'API\\Buyer\\OrderResourceController@loadBuyHistoryOrder');
    Route::post('/order/loadBuyOpenPendingOrder', 'API\\Buyer\\OrderResourceController@loadBuyOpenPendingOrder');
    Route::post("/order/openWithConfirm", 'API\\Buyer\\OrderResourceController@openBuyOrderWithConfirm');
    Route::post("/order/{id}/closed", 'API\\Buyer\\OrderResourceController@closedBuyOrder');
    Route::post("/order/{id}/confirm", 'API\\Buyer\\OrderResourceController@confirmBuyOrder');

});