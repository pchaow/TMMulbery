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
use Mockery\Exception;

/**
 * Created by PhpStorm.
 * User: chaow
 * Date: 7/15/2017
 * Time: 9:14 AM
 */
class OrderService
{

    public static function getOrderOpenListByUser($id, $type, $paginate = true)
    {
        $buyer = User::find($id);

        $query = Order::query();
        $query->where('type', '=', $type);
        $query->with(["plant", "plant.user"]);
        $query->where('status', '=', 'Open');

        return $paginate ? $query->paginate() : $query->get();
    }

    public static function getOrderOpenPendingListByUser($id, $type, $paginate = true)
    {
        $buyer = User::find($id);

        $query = $buyer->orders();
        $query->where('type', '=', $type);
        $query->with(["plant", "plant.user"]);
        $query->where(function ($query) {
            $query->orWhere("status", '=', 'Pending');
            $query->orWhere('status', '=', 'Open');
        });
        return $paginate ? $query->paginate() : $query->get();
    }


    public static function getOrderById($id)
    {
        $query = Order::query();
        $query->with(['buyConfirmOrders.buyOrder.plant', 'buyConfirmOrders.sellOrder.plant', 'buyConfirmOrders.buyOrder.user', 'buyConfirmOrders.sellOrder.user']);
        $query->where('id', '=', $id);
        return $query->first();
    }

    public static function openSellOrderList($paginate = true)
    {
        $query = Order::query();
        $query->where('type', '=', "sell");
        $query->with(["plant", "plant.user"]);
        $query->where('status', '=', 'Open');

        return $paginate ? $query->paginate() : $query->get();
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

        DB::beginTransaction();

        try {
            $order->save();
            $pairOrder->save();
            $confirmOrder = self::openConfirmOrder($order, $pairOrder);
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }

        DB::commit();

        return [$order, $confirmOrder];
    }

    public
    static function closedBuyOrder($id)
    {

        $order = null;
        $confirmOrder = null;
        $pairOrder = null;

        DB::beginTransaction();
        try {
            $order = Order::find($id);

            if ($order) {
                $order->status = Order::$STATUS_CLOSE;

                $confirmOrder = $order->buyConfirmOrders()->first();
                if ($confirmOrder) {
                    if ($confirmOrder) $confirmOrder->status = ConfirmOrder::$STATUS_CLOSE;
                    $pairOrder = $confirmOrder->sellOrder()->first();
                    if ($pairOrder) {
                        $pairOrder->status = Order::$STATUS_OPEN;
                        $pairOrder->save();
                    }
                    $confirmOrder->save();
                }
                $order->save();
            }

        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }

        DB::commit();

        return [$order, $confirmOrder];

    }

    public static function loadHistoryOrder($id, $type, $paginate)
    {
        $buyer = User::find($id);

        $query = $buyer->orders();
        $query->where('type', '=', $type);
        $query->with(["plant", "plant.user", "buyConfirmOrders"]);
        $query->where('status', '=', 'Closed');


        return $paginate ? $query->paginate() : $query->get();
    }

    public static function closeSellOrder($id)
    {
        $order = null;
        $confirmOrder = null;
        $pairOrder = null;

        DB::beginTransaction();
        $order = Order::find($id);

        if ($order) {
            $order->status = Order::$STATUS_CLOSE;

            $confirmOrder = $order->sellConfirmOrders()->first();
            if ($confirmOrder) {
                if ($confirmOrder) $confirmOrder->status = ConfirmOrder::$STATUS_CLOSE;
                $pairOrder = $confirmOrder->buyOrder()->first();
                if ($pairOrder) $pairOrder->status = Order::$STATUS_OPEN;
            }
        }


        try {
            if ($order) $order->save();
            if ($confirmOrder) $confirmOrder->save();
            if ($pairOrder) $pairOrder->save();
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }

        DB::commit();

        return [$order, $confirmOrder];
    }

    public static function getOrderListByUserId($id, $paginate = true, $role = null, $with = ['plant'])
    {
        $user = User::find($id);

        $data = null;
        if ($role == "farmer") {
            $data = $user->sellOrders()->with(["sellConfirmOrders.buyOrder.user"]);
        } elseif ($role == "buyer") {
            $data = $user->orders();
        }

        $data->with($with);

        return $paginate ? $data->paginate() : $data->get();
    }

    public static function confirmBuyOrder($buyOrderId, $formData)
    {
        DB::beginTransaction();
        $buyOrder = Order::find($buyOrderId);
        $confirmOrder = $buyOrder->buyConfirmOrders()->first();
        $sellOrder = $confirmOrder->sellOrder()->first();
        try {

            $confirmOrder->remark = $formData['remark'];
            $confirmOrder->status = ConfirmOrder::$STATUS_SUCCESS;

            $confirmOrder->save();

            if($sellOrder){
                $sellOrder->status = Order::$STATUS_CLOSE;
                $sellOrder->save();
            }

            $buyOrder->status = Order::$STATUS_CLOSE;
            $buyOrder->save();

        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }


        DB::commit();
        return $confirmOrder;

    }
}