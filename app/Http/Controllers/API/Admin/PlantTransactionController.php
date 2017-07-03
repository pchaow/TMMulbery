<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Plant;
use App\Models\PlantTransaction;
use App\Models\PlantTransactionStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlantTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($plantId)
    {
        $query = Plant::query();
        $query->orderBy('created_at', 'desc');

        $query->where('id', '=', $plantId);

        $plant = $query->first();
        return $plant->transactions()->with("status")->paginate();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function initialFarm(Request $request, $plantId)
    {
        $plant = Plant::find($plantId);
        $form = $request->all();

        $status = PlantTransactionStatus::where('name', '=', 'N')->first();
        $transaction = new PlantTransaction();
        $transaction->fill($form);
        $transaction->balance = 0;
        $transaction->status()->associate($status);
        $plant->transactions()->save($transaction);
        return $transaction;
    }

    public function harvestFarm(Request $request, $plantId)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $plantId)
    {
        $plant = Plant::find($plantId);
        $form = $request->all();
        if ($plant->transactions()->count() == 0) {
            if ($form['type'] == "+") {
                return $this->initialFarm($request, $plantId);
            }
        } else if ($form['type'] == "-") {
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
