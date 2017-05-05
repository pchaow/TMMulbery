<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function sum_users_by_type()
    {
        $roles = Role::all();
        $output = [];
        foreach ($roles as $role) {
            $output[$role->name] = $role->users->count();
        }
        return $output;
    }
}
