<?php

namespace App\Http\Services;

use App\Models\ConfirmOrder;
use App\Models\Order;
use App\Models\Plant;
use App\Models\PlantTransaction;
use App\Models\PlantTransactionStatus;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Created by PhpStorm.
 * User: chaow
 * Date: 7/15/2017
 * Time: 9:14 AM
 */
class BuyerService
{

    public static function getBuyersList($keyword = null, $paginate = true)
    {

        $query = User::query();
        $query->with(["province", 'district', 'amphure']);

        if ($keyword != null) {
            $query->where(function ($q) use ($keyword) {
                $q->orWhere('email', 'LIKE', "%$keyword%");
                $q->orWhere('username', 'LIKE', "%$keyword%");
                $q->orWhere('name', 'LIKE', "%$keyword%");
            });

        }

        $query->whereHas('roles', function ($q) {
            $q->where('name', 'buyer');
        });

        if ($paginate) {
            return $query->paginate();
        } else {
            return $query->get();
        }


    }

    public static function getBuyerById($id, $with = [])
    {
        $query = User::query();

        $query->with($with);

        $query->with(['amphure', 'district', 'province']);
        $query->where('id', $id);
        $buyer = $query->first();

        if (!$buyer->hasRole('buyer')) {
            return null;
        }

        return $buyer;
    }


    public static function getBuyerByIdWithFullData($id)
    {
        $buyer = BuyerService::getBuyerById($id, ['buyOrders', 'buyOrders.plant', 'buyOrders.plant.user']);
        return $buyer;

    }

    public static function storeBuyer($formData)
    {
        $form = $formData;
        $user = new User();
        $user->fill($form);
        if (isset($form['password'])) {
            $user->password = Hash::make($form['password']);
        }

        if ($user->province_id == 0) $user->province_id = null;
        if ($user->amphure_id == 0) $user->amphure_id = null;
        if ($user->district_id == 0) $user->district_id = null;

        $user->save();

        $buyer = RoleService::getRoleByName("buyer");
        $user->roles()->save($buyer);
        $user->roles;
        return $user;
    }

    public static function updateBuyer($id, $formData)
    {
        $form = $formData;
        $user = User::find($id);
        $user->fill($form);


        if ($user->province_id == 0) $user->province_id = null;
        if ($user->amphure_id == 0) $user->amphure_id = null;
        if ($user->district_id == 0) $user->district_id = null;

        if (isset($form['password'])) {
            $user->password = Hash::make($form['password']);
        }

        $user->save();

        return $user;
    }

    public static function getChildrenPlant($userId)
    {
        $currentUser = Auth::user();
        $users = $currentUser->children()->get();
        $user_ids = array_pluck($users, 'id');

        $query2 = Plant::query();
        $query2->with(['user']);
        $query2->whereIn('user_id', $user_ids);
        $plants2 = $query2->get();


        foreach ($plants2 as $plant) {
            $plant->remainingBalance = $plant->remainingBalance();
            $plant->lastHarvestDate = $plant->lastHarvestDate();
            $plant->distanceFromPiankusol = $plant->distanceFromPiankusol();

        }
        return $plants2;
    }


    public static function planning($userId, $formData)
    {

        $dateStr = $formData['date'];
        $date = Carbon::parse($dateStr);

        $query = Plant::query();
        $query->with(['user']);
        $query->where('user_id', $userId);
        $plants = $query->get();

        foreach ($plants as $plant) {
            $plant->planningBalance = $plant->planningBalance($date);
            $plant->planningHarvestDate = $plant->planningHarvestDate($date);
            $plant->amount = $plant->amount();
            $plant->distanceFromPiankusol = $plant->distanceFromPiankusol();
        }

        $currentUser = Auth::user();
        $users = $currentUser->children()->get();
        $user_ids = array_pluck($users, 'id');

        $query2 = Plant::query();
        $query2->with(['user']);
        $query2->whereIn('user_id', $user_ids);

        $plants2 = $query2->get();

        foreach ($plants2 as $plant) {
            $plant->planningBalance = $plant->planningBalance($date);
            $plant->planningHarvestDate = $plant->planningHarvestDate($date);
            $plant->amount = $plant->amount();
            $plant->distanceFromPiankusol = $plant->distanceFromPiankusol();
        }

        $p1 = Collection::make($plants);
        $p2 = Collection::make($plants2);

        return [$p1, $p2];
    }


    public static function loadEvents($userId, $startDate = null, $endDate = null)
    {
        //confirm orders
        $query = ConfirmOrder::query();
        $query->whereHas("buyOrder", function ($query) use ($userId, $startDate, $endDate) {
            $query->where('user_id', $userId);
            $query->whereBetween('duedate', [$startDate, $endDate]);

        });
        $query->where("status",'!=', ConfirmOrder::$STATUS_CLOSE);
        $confirmOrders = $query->get();

        //plant transaction

        $query = PlantTransaction::query();

        $updateStatus = PlantTransactionStatus::where('name', 'U')->first();

        $query->whereHas('plant', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });

        $query->whereHas('status', function ($q) use ($updateStatus) {
            $q->where('name', '!=', $updateStatus->name);
        });
        $query->whereBetween('transaction_date', [$startDate, $endDate]);


        $plantTransactions = $query->get();


        $events = [];

        foreach ($confirmOrders as $order) {
            $e = [];
            $buyOrder = $order->buyOrder()->first();
            $e['type'] = "order";
            $e['title'] = "[$order->status] "."ID : $buyOrder->id : Confirm Buy Order ";
            $e['start'] = $buyOrder->duedate;
            $e['end'] = $buyOrder->duedate;
            $e['status'] = $order->status;
            $events[] = $e;
        }

        foreach ($plantTransactions as $transaction) {
            $e = [];

            $status = $transaction->status;
            $e['type'] = "plantTransaction";
            $e['title'] = "[" . $transaction->plant->name . "] : $status->display_name";
            $e['start'] = $transaction->transaction_date;
            $e['end'] = $transaction->transaction_date;
            $events[] = $e;
        }


        return $events;

    }

    public static function getPlantLists($userId)
    {

       // $dateStr = $formData['date'];
       // $date = Carbon::parse($dateStr);

        $query = Plant::query();
        $query->with(['user']);
        $query->where('user_id', $userId);
        $plants = $query->get();

        $currentUser = Auth::user();
        $users = $currentUser->children()->get();
        $user_ids = array_pluck($users, 'id');

        $query2 = Plant::query();
        $query2->with(['user']);
        $query2->whereIn('user_id', $user_ids);

        $plants2 = $query2->get();

       // foreach ($plants2 as $plant) {
      //      $plant->planningBalance = $plant->planningBalance($date);
      //      $plant->planningHarvestDate = $plant->planningHarvestDate($date);
     //       $plant->amount = $plant->amount();
     //       $plant->distanceFromPiankusol = $plant->distanceFromPiankusol();
     //   }

        $p1 = Collection::make($plants);
        $p2 = Collection::make($plants2);

        return [$p1, $p2];
    }


}