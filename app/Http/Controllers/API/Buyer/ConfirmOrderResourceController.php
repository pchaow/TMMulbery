<?php

namespace App\Http\Controllers\API\Buyer;

use App\Http\Services\ConfirmOrderService;
use App\Http\Services\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ConfirmOrderResourceController extends Controller
{

    public function show($id)
    {
        return ConfirmOrderService::getConfirmOrderById($id);
    }

    public function confirmConfirmOrder(Request $request, $id)
    {
        $confirmOrderId = $id;
        $formData = $request->all();
        return ConfirmOrderService::confirmConfirmOrder($confirmOrderId, $formData);
    }


}
