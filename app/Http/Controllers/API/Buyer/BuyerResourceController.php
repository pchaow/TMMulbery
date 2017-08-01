<?php

namespace App\Http\Controllers\API\Buyer;

use App\Http\Requests\PlanningRequest;
use App\Http\Services\PlantService;
use App\Http\Services\UserService;
use App\Models\User;
use App\Http\Services\BuyerService;
use Carbon\Carbon;
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

    public function childrenPlant()
    {
        return BuyerService::getChildrenPlant(Auth::user()->id);
    }

    public function updateRating(Request $request)
    {
        $plantId = $request->get('plant_id');
        $rating = $request->get('rating');

        return PlantService::updateRating($plantId, $rating);
    }

    public function loadEvents(Request $request)
    {
        $start = Carbon::createFromTimestamp($request->get('start'));
        $end = Carbon::createFromTimestamp($request->get('end'));

//        return [$start, $end];
        return BuyerService::loadEvents(Auth::user()->id, $start, $end);
    }
}
