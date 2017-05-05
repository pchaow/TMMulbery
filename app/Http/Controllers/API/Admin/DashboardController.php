<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function sum_users_by_type()
    {
        $query = Role::query();
        $query->select(['name']);
        $query->addSelect(DB::raw('count(role_user.user_id) as users'));

        $query->join('role_user', 'roles.id', '=', 'role_user.role_id');
        $query->groupBy('roles.name');

        $roles = $query->get();
        $map = [];
        $i = 0;
        foreach ($roles as $role) {
            $map[$role->name] = ['name' => $role->name, 'index' => sizeof($map), 'users' => $role->users];
        }

        //return $map;
        $output = [];
        $output['labels'] = array_fill(0, sizeof($map), "");
        $output['series'] = [];

        $x = new \stdClass();
        $x->name = 'Roles';
        $x->data = array_fill(0, sizeof($map), 0);

        foreach ($map as $m) {
            $output['labels'][$m['index']] = $m['name'];
            $x->data[$m['index']] = $m['users'];
        }
        $output['series'] = $x;


        return $output;
    }
}
