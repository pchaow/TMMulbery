<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\PlantRequest;
use App\Http\Requests\UserRequest;
use App\Models\Plant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class FarmerPlantResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $farmerId)
    {
        $farmer = User::find($farmerId);
        return $farmer->plants()->with(['province', 'amphure', 'district'])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($farmerId)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlantRequest $request, $farmerId)
    {
        $farmer = User::find($farmerId);
        $form = $request->all();
        $plant = new Plant();
        if ($farmer) {
            $plant->fill($form);
            $plant->user()->associate($farmer);
            $plant->save();
            return $plant;

        } else {
            return abort(404, 'Error.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($farmerId, $plantId)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $farmerId, $plantId)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlantRequest $request, $farmerId, $plantId)
    {
        $farmer = User::find($farmerId);
        $form = $request->all();
        $plant = Plant::find($plantId);
        if ($farmer && $plant) {
            $plant->fill($form);
            $plant->save();
            return $plant;
        } else {
            return abort(404, 'Error.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($farmerId, $plantId)
    {

    }
}
