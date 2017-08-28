<?php

namespace App\Http\Controllers\API\Profile;

use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileResourceController extends Controller
{


    public function edit($id)
    {
        $query = User::query()->where("id", $id);
        $query->with(['amphure', 'district', 'province']);
        //$user->roles;

        $user = $query->first();
        $user->roles;

        $user->province_name = $user->province ? $user->province->name : '';
        $user->amphure_name = $user->amphure ? $user->amphure->name : '';
        $user->district_name = $user->district ? $user->district->name : '';

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
}
