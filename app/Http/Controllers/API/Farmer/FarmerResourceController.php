<?php

namespace App\Http\Controllers\API\Farmer;

use App\Http\Requests\FarmerRequest;
use App\Http\Services\FarmerService;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FarmerResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return FarmerService::getFarmerById(Auth::user()->id);
    }

    public function createSellOrder(Request $request, $plantId)
    {
        $userId = Auth::user()->id;
        return FarmerService::createSellOrderTransaction($userId, $plantId, $request->all());
    }

}
