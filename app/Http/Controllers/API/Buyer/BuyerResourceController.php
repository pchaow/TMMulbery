<?php

namespace App\Http\Controllers\API\Buyer;

use App\Http\Requests\PlanningRequest;
use App\Http\Services\UserService;
use App\Models\User;
use App\Http\Services\BuyerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BuyerResourceController extends Controller
{
    public function index()
    {
        $buyerId = Auth::user()->id;
        $buyer = BuyerService::getBuyerByIdWithFullData($buyerId);

        return $buyer;

    }

    public function edit($id)
    {
        $user = User::find($id);
        //$user->roles;
        return $user;
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
        return UserService::updateProfile($id, $request->all());


    }


    public function plan(PlanningRequest $request)
    {
        return BuyerService::planning(Auth::user()->id, $request->all());
    }
}
