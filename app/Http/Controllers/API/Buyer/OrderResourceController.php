<?php

namespace App\Http\Controllers\API\Buyer;

use App\Http\Services\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    public function loadBuyOpenPendingOrder(Request $request)
    {
        $buyer = Auth::user();
        return OrderService::getOrderOpenPendingListByUser($buyer->id, "buy", false);
    }

    public function loadSellOpenOrder(Request $request)
    {
        $buyer = Auth::user();
        return OrderService::getOrderOpenListByUser($buyer->id, "sell", true);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return OrderService::getOrderById($id);
    }

    public function openBuyOrder()
    {
        return OrderService::openBuyOrder();
    }

    public function openBuyOrderWithConfirm(Request $request)
    {
        return OrderService::openBuyOrderWithConfirm(Auth::user()->id, $request->all());
    }

    public function closedBuyOrder($id)
    {
        return OrderService::closedBuyOrder($id);
    }
}
