<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\FarmerService;
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
        $user = FarmerService::getFarmerById($userId);

        if ($user == null) {
        return redirect("/admin/farmers");
    }

        return view('admin.farmer.edit')
            ->with('userId', $userId);

    }

    public function view($farmerId)
    {

        $farmer = FarmerService::getFarmerByIdWithPlantFullData($farmerId);

        if ($farmer == null) {
            return redirect("/admin/farmers");
        }

        return view('admin.farmer.view')
            ->with('farmer', $farmer);

    }

}
