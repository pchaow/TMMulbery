<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\Plant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Created by PhpStorm.
 * User: chaow
 * Date: 7/15/2017
 * Time: 9:14 AM
 */
class UserService
{

    public static function getOrderListByUserId($id, $paginate = true, $role = null, $with = ["plant"])
    {
        $user = User::find($id);

        $data = null;
        if ($role == "farmer") {
            $data = $user->sellOrders();
        } elseif ($role == "buyer") {
            $data = $user->orders();
        }

        $data->with($with);

        return $paginate ? $data->paginate() : $data->get();
    }

}