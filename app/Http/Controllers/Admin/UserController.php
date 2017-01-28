<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function create()
    {
        return view('admin.user.create');

    }

    public function edit($userId)
    {
        if (!User::find($userId)) {
            return redirect("/admin/users");
        }
        return view('admin.user.edit')
            ->with('userId', $userId);

    }

}
