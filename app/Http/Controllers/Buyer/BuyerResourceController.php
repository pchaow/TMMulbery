<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Services\BuyerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BuyerResourceController extends Controller
{
    //
    public function buyList()
    {
        $buyerId = Auth::user()->id;
        $buyer = BuyerService
            ::getBuyerByIdWithFullData($buyerId);

        return view("buyer.buylist")
            ->with('buyer', $buyer);
    }
    public function sellList()
    {
        return view('buyer.selllist');
    }

    public function confirm($confirmId)
    {
        return view('buyer.orderConfirm')
            ->with("confirmOrderId", $confirmId);
    }
}
