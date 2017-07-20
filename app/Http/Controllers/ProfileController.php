<?php

namespace App\Http\Controllers;

use App\Http\Services\BuyerService;
use App\Http\Services\FarmerService;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laratrust\Laratrust;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewProfileByUserId($userId)
    {
        if (Auth::user()->id == $userId) {
            $user = UserService::getUserById($userId);

            if ($user == null) {
                return redirect("/home");
            }

            return view('user.profile')
                ->with('userId', $user->id);
        }else{
            return null;
        }

    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->id == $id) {
            $form = $request->all();
            $user = User::find($id);
            $user->fill($form);


            if (isset($form['password'])) {
                $user->password = Hash::make($form['password']);
            }

            $user->save();

            if (isset($form['roles'])) {
                $roleIds = [];
                foreach ($form['roles'] as $role) {
                    $roleIds[] = $role['id'];
                }
                $user->roles()->sync($roleIds);
            }
            $user->roles;
            return $user;
        }else{
        return null;}
    }

}

