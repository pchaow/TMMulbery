<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Services\PlantTransactionService;
use App\Models\Plant;
use App\Models\PlantTransaction;
use App\Models\PlantTransactionStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlantTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($plantId)
    {
        return PlantTransactionService::getTransactionListByPlantId($plantId);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function initialFarm(Request $request, $plantId)
    {
        return PlantTransactionService::initialFarm($plantId, $request->all());
    }


    public function harvestFarm(Request $request, $plantId)
    {
        return PlantTransactionService::harvestFarm($plantId,$request->all());
    }

}
