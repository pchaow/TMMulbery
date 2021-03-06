<?php

namespace App\Http\Controllers\API\Farmer;

use App\Http\Requests\PlantRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\OrderService;
use App\Http\Services\PlantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmerPlantResourceController extends Controller
{
    public function index(Request $request)
    {
        return PlantService::getPlantListByFarmerId(Auth::user()->id);
    }

    public function store(PlantRequest $request)
    {
        $id = Auth::user()->id;
        return PlantService::storePlantToFarmer($id, $request->all());
    }

    public function update(PlantRequest $request, $plantId)
    {
        $id = Auth::user()->id;
        return PlantService::updatePlantToFarmer($id, $plantId, $request->all());
    }

    public function destroy($plantId)
    {
        return PlantService::destroyPlant($plantId);
    }

    public function show($id)
    {
        return PlantService::getPlantById($id);
    }




}
