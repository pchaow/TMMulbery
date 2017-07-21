<?php

namespace App\Http\Controllers\API\Farmer;

use App\Http\Requests\FarmerRequest;
use App\Http\Services\FarmerService;
use App\Http\Services\OrderService;
use App\Http\Services\UserService;
use App\Models\Order;
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
        return OrderService::createSellOrderTransaction($userId, $plantId, $request->all());
    }

    public function openSellOrder(Request $request)
    {
        $userId = Auth::user()->id;
        return OrderService::openSellOrderWithoutPlant($userId, $request->all());
    }

    public function getOrders()
    {
        $id = Auth::user()->id;
        $orders = OrderService::getOrderListByUserId($id, true, "farmer");

        return $orders;
    }

    public function closeSellOrder(Request $request, $id)
    {
        return OrderService::closeSellOrder($id);
    }

    public function loadBuyOpenOrder(Request $request)
    {
        return OrderService::openBuyOrderList();
    }

    public function openWithConfirm(Request $request)
    {
        return OrderService::openSellOrderWithConfirm(Auth::user()->id,$request->all());
    }
}
