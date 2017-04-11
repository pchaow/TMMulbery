<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plant;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FarmerPlantController extends Controller
{

    public function create($userId)
    {
        $user = User::with(['plants', 'amphure', 'district', 'province'])->where('id', $userId)->first();
        if (!$user->hasRole('farmer')) {
            return redirect("/admin/farmers");
        }

        return view('admin.farmer.plant.create')
            ->with('user', $user);

    }

    public function edit($userId, $plantId)
    {
        $user = User::with(['plants', 'amphure', 'district', 'province'])->where('id', $userId)->first();
        $plant = Plant::find($plantId);

        return view('admin.farmer.plant.edit')
            ->with('user', $user)
            ->with('plant', $plant);
    }

    public function view($userId)
    {
    }

}
