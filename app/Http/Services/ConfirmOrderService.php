<?php

namespace App\Http\Services;

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
class ConfirmOrderService
{
    public static  function getConfirmOrderById($id){
        $q = ConfirmOrder::query();
        $q->with(['buyOrder.plant','buyOrder.user']);
        $q->with(['sellOrder.plant','sellOrder.user']);
        $q->where('id','=',$id);
        return $q->first();
    }

    public static function confirmConfirmOrder($confirmOrderId, $formData)
    {
        DB::beginTransaction();

        $confirmOrder = ConfirmOrder::find($confirmOrderId);

        $buyOrder = $confirmOrder->buyOrder()->first();
        $sellOrder = $confirmOrder->sellOrder()->first();
        try {

            $confirmOrder->remark = $formData['remark'];
            $confirmOrder->status = ConfirmOrder::$STATUS_SUCCESS;

            $confirmOrder->save();

            if ($sellOrder) {
                $sellOrder->status = Order::$STATUS_CLOSE;
                $sellOrder->save();

                if($sellOrder->plant_id){
                    //do harvesting.
                    $form = [
                        "amount" => $formData['remark']["unit"],
                        "status" => "H",
                        "transaction_date" => Carbon::now(),
                        "type" => "-",
                    ];
                    PlantTransactionService::harvestFarm($sellOrder->plant_id, $form);
                }
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