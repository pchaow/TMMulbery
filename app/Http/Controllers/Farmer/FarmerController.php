<?php

namespace App\Http\Controllers\Farmer;

use App\Models\Plant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FarmerController extends Controller
{
    public function createPlant()
    {
        $user = Auth::user();
        $user->plants;
        $user->amphure;
        $user->district;
        $user->province;
        return view("farmer.plant.create")->with('user', $user);;
    }

    public function editPlant( $plantId)
    {
        $user = Auth::user();
        $user->plants;
        $user->amphure;
        $user->district;
        $user->province;

        $plant = Plant::find($plantId);

        $plant->province_name = $plant->province ? $plant->province->name : '';
        $plant->amphure_name = $plant->amphure ? $plant->amphure->name : '';
        $plant->district_name = $plant->district ? $plant->district->name : '';

        return view('farmer.plant.edit')
            ->with('user', $user)
            ->with('plant', $plant);
    }
}
