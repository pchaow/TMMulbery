<?php

namespace App\Http\Controllers\API\Buyer;

use App\Http\Services\BuyerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    public function index()
    {
        $buyerId = Auth::user()->id;
        $buyer = BuyerService::getBuyerByIdWithFullData($buyerId);

        return $buyer;

    }
}
