<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\PlantRequest;
use App\Http\Requests\UserRequest;
use App\Http\Services\FarmerService;
use App\Http\Services\PlantService;
use App\Models\Plant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class FarmerPlantResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $farmerId)
    {
        return PlantService::getPlantListByFarmerId($farmerId);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($farmerId)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlantRequest $request, $farmerId)
    {
        return PlantService::storePlantToFarmer($farmerId, $request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($farmerId, $plantId)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $farmerId, $plantId)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlantRequest $request, $farmerId, $plantId)
    {
        return PlantService::updatePlantToFarmer($farmerId, $plantId, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($farmerId, $plantId)
    {
        return PlantService::destroyPlant($plantId);
    }
}
