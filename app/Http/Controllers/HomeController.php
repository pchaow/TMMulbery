<?php

namespace App\Http\Controllers;

use App\Http\Services\BuyerService;
use App\Http\Services\FarmerService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laratrust\Laratrust;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('administrator')) {
            return view('admin.home');
        } elseif ($user->hasRole('farmer')) {
            return $this->farmerHome();
        } elseif ($user->hasRole('buyer')) {
            return $this->buyerHome();
        }
    }

    private function buyerHome()
    {
        $buyerId = Auth::user()->id;
        $buyer = BuyerService::getBuyerByIdWithFullData($buyerId);

        return view("buyer.home")
            ->with('buyer', $buyer);
    }

    private function farmerHome()
    {
        $user = Auth::user();
        $userId = $user->id;

        $user = FarmerService::getFarmerByIdWithPlantFullData($userId);

        return view('farmer.home')
            ->with('farmer', $user);

    }
}

