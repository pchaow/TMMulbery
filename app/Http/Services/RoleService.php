<?php
/**
 * Created by PhpStorm.
 * User: chaow
 * Date: 7/15/2017
 * Time: 10:15 AM
 */

namespace App\Http\Services;


class RoleService
{
    public static function getRoleByName($name)
    {
        $farmer = Role::where('name', $name)->first();
        return $farmer;
    }
}