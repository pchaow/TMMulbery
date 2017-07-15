<?php

namespace App\Http\Services;
/**
 * Created by PhpStorm.
 * User: chaow
 * Date: 7/15/2017
 * Time: 9:14 AM
 */
class FarmerService
{

    public static function getFarmerById($id)
    {
        $farmer = \App\Models\User::with(['plants', 'plants.province', 'plants.amphure', 'plants.district'
            , 'amphure', 'district', 'province'])->where('id', $id)->first();

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

}