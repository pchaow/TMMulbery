<?php

namespace App\Http\Controllers\API\Farmer;

use App\Http\Requests\PlantRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\PlantService;
use Illuminate\Support\Facades\Auth;

class FarmerPlantResourceController extends Controller
{
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
}
