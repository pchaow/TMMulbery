<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FarmerController extends Controller
{
    public function index()
    {
        return view('admin.farmer.index');
    }

    public function create()
    {
        return view('admin.farmer.create');

    }

    public function edit($userId)
    {
        if (!User::find($userId)->hasRole('farmer')) {
            return redirect("/admin/farmers");
        }

        return view('admin.farmer.edit')
            ->with('userId', $userId);

    }

    public function view($userId)
    {
        if (!User::find($userId)->hasRole('farmer')) {
            return redirect("/admin/farmers");
        }

        return view('admin.farmer.view')
            ->with('userId', $userId);

    }

}
