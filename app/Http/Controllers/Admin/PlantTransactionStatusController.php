<?php

namespace App\Http\Controllers\Admin;

use App\Models\PlantTransactionStatus;
use App\Http\Controllers\Controller;

class PlantTransactionStatusController extends Controller
{
    public function index()
    {
        return view('admin.plant_transaction_status.index');
    }

    public function create()
    {
        return view('admin.plant_transaction_status.create');

    }

    public function edit($id)
    {
        if (!PlantTransactionStatus::find($id)) {
            return redirect('/admin/plant_transaction_status');
        }
        return view('admin.plant_transaction_status.edit')
            ->with('id', $id);

    }
}
