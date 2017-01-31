<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FarmerPlantController extends Controller
{

    public function create()
    {
        return view('admin.farmer.plant.create');

    }

    public function edit($userId)
    {
    }

    public function view($userId)
    {
    }

}
