<?php

namespace App\Http\Services;

use App\Http\Requests\UserRequest;
use App\Models\ConfirmOrder;
use App\Models\Order;
use App\Models\Plant;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
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

        $query = $buyer->orders()->with(["sellPairedOrder", "sellPairedOrder.user", "sellPairedOrder.plant"]);
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

    public static function openBuyOrderList($paginate = true)
    {
        $query = Order::query();
        $query->where('type', '=', "buy");
        $query->with(["user"]);
        $query->where('status', '=', 'Open');

        return $paginate ? $query->paginate() : $query->get();
    }

    public static function openSellOrderList($paginate = true)
    {
        $query = Order::query();
        $query->where('type', '=', "sell");
        $query->with(["plant", "plant.user", "user"]);
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

    public static function openBuyOrder($userId, $formData)
    {
        $user = User::find($userId);
        $order = new Order();
        $order->user()->associate(User::find($userId));

        $order->duedate = $formData['duedate'];
        $order->amount = $formData['amount'];
        $order->type = Order::$ORDER_TYPE_BUY;
        $order->status = Order::$STATUS_OPEN;

        $order->save();
        return $order;
    }

    public static function openBuySellOrderWithConfirm($userId, $formData)
    {
        $plant = Plant::find($formData['plant']['id']);
        $farmer = User::find($formData['plant']['user_id']);

        $buyOrder = new Order();
        $buyOrder->user()->associate(User::find($userId));
        if ($plant) {
            $buyOrder->plant()->associate($plant);
        }
        $buyOrder->amount_rai = $formData['amount_rai'];
        $buyOrder->amount_kg = $formData['amount_kg'];
        $buyOrder->duedate = $formData['date'];
        $buyOrder->type = Order::$ORDER_TYPE_BUY;
        $buyOrder->status = Order::$STATUS_PENDING;


        $sellOrder = new Order();
        $sellOrder->user()->associate($farmer);
        if ($plant) {
            $sellOrder->plant()->associate($plant);
        }
        $sellOrder->amount_rai = $formData['amount_rai'];
        $sellOrder->amount_kg = $formData['amount_kg'];
        $sellOrder->duedate = $formData['date'];
        $sellOrder->type = Order::$ORDER_TYPE_SELL;
        $sellOrder->status = Order::$STATUS_PENDING;


        $confirmOrder = null;

        DB::beginTransaction();

        try {
            $buyOrder->save();
            $sellOrder->save();
            $confirmOrder = self::openConfirmOrder($buyOrder, $sellOrder);
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }

        DB::commit();

        return [$buyOrder, $sellOrder, $confirmOrder];
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

        $query = $buyer->orders()->with(["sellPairedOrder", "sellPairedOrder.user", "sellPairedOrder.plant"]);
        $query->where('type', '=', $type);
        $query->with(["plant", "plant.user"]);
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

            if ($sellOrder) {
                $sellOrder->status = Order::$STATUS_CLOSE;
                $sellOrder->save();

                //do harvesting.
                $form = [
                    "amount" => $formData['remark']["unit"],
                    "status" => "H",
                    "transaction_date" => Carbon::now(),
                    "type" => "-",
                ];

                PlantTransactionService::harvestFarm($sellOrder->plant_id, $form);
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

    public static function createSellOrderTransaction($userId, $plantId, $formData)
    {
        $user = User::find($userId);
        $plant = Plant::find($plantId);

        $order = new Order();

        $order->fill($formData);
        $order->type = Order::$ORDER_TYPE_SELL;
        $order->status = Order::$STATUS_OPEN;

        $order->user()->associate($user);
        $order->plant()->associate($plant);

        $order->save();

        return $order;
    }

    public static function openSellOrderWithoutPlant($userId, $formData)
    {
        $user = User::find($userId);

        $order = new Order();

        $order->fill($formData);
        $order->type = Order::$ORDER_TYPE_SELL;
        $order->status = Order::$STATUS_OPEN;

        $order->user()->associate($user);

        $order->save();

        return $order;
    }

    public static function openSellOrderWithConfirm($userId, $formData)
    {
        $buyOrder = Order::find($formData['order_id']);
        $buyOrder->status = Order::$STATUS_PENDING;
        $buyOrder->save();
        $sellOrder = new Order();

        $sellOrder->amount = $buyOrder->amount;
        $sellOrder->duedate = $buyOrder->duedate;
        $sellOrder->type = Order::$ORDER_TYPE_SELL;
        $sellOrder->status = Order::$STATUS_PENDING;
        $sellOrder->user()->associate(User::find($userId));

        $sellOrder->save();

        $confirmOrder = self::openConfirmOrder($buyOrder, $sellOrder);

        return [$sellOrder, $confirmOrder];
    }
}