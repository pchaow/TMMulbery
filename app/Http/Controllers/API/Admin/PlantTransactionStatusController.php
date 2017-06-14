<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\PlantTransactionStatusRequest;
use App\Models\PlantTransactionStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlantTransactionStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = PlantTransactionStatus::query();

        if ($request->has('keyword')) {
            $keyword = $request->get('keyword');
            $query->orWhere('name', 'LIKE', "%$keyword%");
            $query->orWhere('display_name', 'LIKE', "%$keyword%");
            $query->orWhere('description', 'LIKE', "%$keyword%");

        }
        return $query->paginate();
    }


    public function show($id)
    {
        $query = PlantTransactionStatus::query();
        $query->where('id', $id);

        return $query->first();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlantTransactionStatusRequest $request)
    {
        $form = $request->all();
        $status = new PlantTransactionStatus();
        $status->fill($form);

        $status->save();
        return $status;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlantTransactionStatusRequest $request, $id)
    {
        $form = $request->all();
        $status = PlantTransactionStatus::find($id);
        $status->fill($form);

        $status->save();
        return $status;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = PlantTransactionStatus::find($id);
        $status->delete();
        return [true];
    }
}
