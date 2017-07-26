<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Services\FarmerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BuyerPlantController extends Controller
{
    function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        $user = FarmerService::getFarmerById($userId);

        return view('farmer.home')
            ->with('farmer', $user);
    }
}
