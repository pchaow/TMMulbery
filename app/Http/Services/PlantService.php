<?php
/**
 * Created by PhpStorm.
 * User: chaow
 * Date: 7/15/2017
 * Time: 10:20 AM
 */

namespace App\Http\Services;


use App\Models\Plant;
use App\Models\User;

class PlantService
{
    private static function createSearchQuery($keyword = null)
    {

        $query = Plant::query();
        $query->with(['user', 'province', 'amphure', 'district']);

        if ($keyword) {
//            $query->orWhere('email', 'LIKE', "%$keyword%");
//            $query->orWhere('username', 'LIKE', "%$keyword%");
//            $query->orWhere('name', 'LIKE', "%$keyword%");
        }

        return $query;
    }

    private static function appendOptions($list, $options)
    {

        foreach ($list as $data) {

            foreach ($options as $opt => $value) {
                if ($value == true) {
                    $data->$opt = $data->$opt();
                }
            }
        }

        return $list;
    }

    public static function getPlantById($id)
    {
        $query = self::createSearchQuery(null);
        $plant = $query->where('id', '=', $id)->first();

        return $plant;
    }

    public static function getPlantList($keyword = null, $paginate = true)
    {

        $query = self::createSearchQuery($keyword);

        $query->with('user');

        if ($paginate) {
            return $query->paginate();
        } else {
            return $query->get();
        }
    }

    public static function getPlantListByFarmerId($farmerId, $keyword = null, $paginate = true)
    {

        $query = self::createSearchQuery($keyword);
        $query->with('user');

        if ($paginate) {
            return $query->paginate();
        } else {
            return $query->get();
        }
    }


    public static function getPlantListWithFullData($keyword = null, $paginate = true, $options = [])
    {
        return self::appendOptions(self::getPlantList($keyword, $paginate), $options);
    }

    public static function getPlantListWithFullDataByFarmerId($farmerId, $keyword = null, $paginate = true, $options = [])
    {
        $query = self::createSearchQuery();
        $query->whereHas("user", function ($query) use ($farmerId) {
            $query->where('id', '=,', $farmerId);
        });

        $list = $paginate ? $query->paginate() : $query->get();

        return self::appendOptions($list, $options);

    }

    public static function storePlantToFarmer($farmerId, $form)
    {

        $farmer = User::find($farmerId);

        $plant = new Plant();
        if ($farmer) {
            $plant->fill($form);
            $plant->user()->associate($farmer);
            $plant->save();
            return $plant;

        } else {
            return abort(404, 'Error.');
        }

    }


    public static function updatePlantToFarmer($farmerId, $plantId, $form)
    {

        $farmer = User::find($farmerId);
        $plant = Plant::find($plantId);
        if ($farmer && $plant) {
            $plant->fill($form);
            $plant->save();
            return $plant;
        } else {
            return abort(404, 'Error.');
        }

    }

    public static function destroyPlant($plantId)
    {
        $plant = Plant::find($plantId);
        $plant->orders()->delete();
        return [$plant->delete()];
    }


}