<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\PlantRequest;
use App\Http\Requests\UserRequest;
use App\Http\Services\PlantService;
use App\Models\Plant;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp;

class PlantResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $keyword = $request->has("keyword") ? $request->get("keyword") : null;
        $options = $request->has("options") ? $request->get("options") : [];

        $page = PlantService::getPlantListWithFullData($keyword, true, $options);

        return $page;
    }


    public function show($id)
    {
        $plant = PlantService::getPlantById($id);

        return $plant;
    }


    public function balance($id)
    {

        $plant = Plant::find($id);
        return $plant->remainingBalance();
    }
}
