<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Services\FarmerService;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FarmerController extends Controller
{
    public function index()
    {
        return view('buyer.farmer.index');
    }

    public function create()
    {
        return view('buyer.farmer.create');

    }

    public function edit($userId)
    {
        $user = FarmerService::getFarmerById($userId);

        if ($user == null) {
        return redirect("/buyer/farmers");
    }

        return view('buyer.farmer.edit')
            ->with('userId', $userId);

    }

}
