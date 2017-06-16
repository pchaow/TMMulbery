<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plant;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PlantController extends Controller
{
    public function index()
    {
        return view('admin.plant.index');
    }

    public function create()
    {
        return view('admin.plant.create');

    }

    public function edit($id)
    {
        return view('admin.plant.edit')
            ->with('plantId', $id);

    }

    public function view($id)
    {
        $plant = Plant::with(['amphure', 'district', 'province'])->where('id','=',$id)->first();

        $user = $plant->user()->with(['amphure', 'district', 'province'])->first();

        return view('admin.plant.view')
            ->with('farmer', $user);

    }

}
