<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Services\BuyerService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    public function index()
    {
        $buyerId = Auth::user()->id;
        $buyer = BuyerService
            ::getBuyerByIdWithFullData($buyerId);

        return view("buyer.home")
            ->with('buyer', $buyer);
    }

    public function plan(){

        $buyerId = Auth::user()->id;
        $buyer = BuyerService
            ::getBuyerByIdWithFullData($buyerId);

        return view("buyer.plan")
            ->with('buyer',$buyer);
    }

    public function plantMap(){

        return view("buyer.plantmap");
    }



}
