<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.role.index');
    }

    public function create()
    {
        return view('admin.role.create');

    }

    public function edit($roleId)
    {
        if (!Role::find($roleId)) {
            return redirect('/admin/roles');
        }
        return view('admin.role.edit')
            ->with('roleId', $roleId);

    }
}
