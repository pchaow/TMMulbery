<?php

namespace App\Http\Services;

use App\Models\ConfirmOrder;
use App\Models\Order;
use App\Models\Plant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Created by PhpStorm.
 * User: chaow
 * Date: 7/15/2017
 * Time: 9:14 AM
 */
class OrderService
{

    private static function addAndWhereOptionsQuery($query, $options)
    {


//        dd($options);die();
        foreach ($options as $key => $value) {
            $query->where($key, '=', $value);
        }

        return $query;

    }

    public static function getOrderListByOrder($buyerId, $paginate = true, $with = [], $options = [])
    {
        $query = Order::query();
        $query->with($with);

        $query = self::addAndWhereOptionsQuery($query, $options);

        $result = $paginate ? $query->paginate() : $query->get();
        return $result;
    }

    public static function getOrderById($id)
    {
        $query = Order::query();
        $query->where('id', '=', $id);
        return $query->first();
    }

    public static function openBuyOrder()
    {
    }

    public static function openConfirmOrder($buyOrder, $sellOrder)
    {
        $confirmOrder = new ConfirmOrder();
        $confirmOrder->buyOrder()->associate($buyOrder);
        $confirmOrder->sellOrder()->associate($sellOrder);
        $confirmOrder->status = ConfirmOrder::$STATUS_PENDING;
        $confirmOrder->remark = [];

        $confirmOrder->save();
        return $confirmOrder;
    }

    public static function openBuyOrderWithConfirm($userId, $formData)
    {
        $pairOrder = Order::find($formData['order_id']);
        $plant = Plant::find($formData['plant_id']);

        $order = new Order();

        $order->user()->associate(User::find($userId));
        $order->plant()->associate($plant);

        $order->amount = $pairOrder->amount;
        $order->type = Order::$ORDER_TYPE_BUY;
        $order->status = Order::$STATUS_PENDING;

        $pairOrder->status = Order::$STATUS_PENDING;

        $confirmOrder = null;

        DB::transaction(function () use ($order, $pairOrder, $confirmOrder) {
            $order->save();
            $pairOrder->save();

            $confirmOrder = self::openConfirmOrder($order, $pairOrder);
        });

        if ($confirmOrder) {
            return [$order, $confirmOrder];
        } else {
            return response()->json(
                ["errorMsg" => "Error"], 422);
        }


    }

    public static function closedBuyOrder($id)
    {
    }
}