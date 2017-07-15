<?php

namespace App\Http\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Created by PhpStorm.
 * User: chaow
 * Date: 7/15/2017
 * Time: 9:14 AM
 */
class FarmerService
{

    public static function getFarmersList($keyword = null, $paginate = true)
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
            $q->where('name', 'farmer');
        });

        if ($paginate) {
            return $query->paginate();
        } else {
            return $query->get();
        }


    }

    public static function getFarmerById($id, $withPlant = true)
    {
        $query = User::query();

        if ($withPlant) {
            $query->with(['plants', 'plants.province', 'plants.amphure', 'plants.district']);
        }
        $query->with(['amphure', 'district', 'province']);
        $query->where('id', $id);
        $farmer = $query->first();

        if (!$farmer->hasRole('farmer')) {
            return null;
        }

        return $farmer;
    }

    public static function getFarmerByIdWithPlantFullData($id)
    {
        $farmer = FarmerService::getFarmerById($id);
        if ($farmer) {
            foreach ($farmer->plants as $data) {
                $data->remainingBalance = $data->remainingBalance();
                $data->lastHarvestDate = $data->lastHarvestDate();
                $data->hasTransaction = $data->transactions()->first() != null ? true : false;
            }
        }

        return $farmer;

    }

    public static function storeFarmer($formData)
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

        $farmer = RoleService::getRoleByName("farmer");
        $user->roles()->save($farmer);
        $user->roles;
        return $user;
    }

    public static function updateFarmer($id,$formData){
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


}