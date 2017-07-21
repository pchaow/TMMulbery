<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerResourceController extends Controller
{
    //

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
