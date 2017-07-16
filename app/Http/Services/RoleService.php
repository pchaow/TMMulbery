<?php
/**
 * Created by PhpStorm.
 * User: chaow
 * Date: 7/15/2017
 * Time: 10:15 AM
 */

namespace App\Http\Services;
use App\Models\Role;


class RoleService
{
    public static function getRoleByName($name)
    {
        $user = Role::where('name', $name)->first();
        return $user;
    }
}