<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class FarmerResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = User::query();

        if ($request->has('keyword')) {
            $keyword = $request->get('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->orWhere('email', 'LIKE', "%$keyword%");
                $q->orWhere('username', 'LIKE', "%$keyword%");
                $q->orWhere('name', 'LIKE', "%$keyword%");
            });

        }

        $query->whereHas('roles', function ($q) {
            $q->where('name', 'farmer');
        });

        return $query->paginate();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $form = $request->all();
        $user = new User();
        $user->fill($form);
        $user->password = Hash::make($form['password']);
        $user->save();

        $farmer = Role::where('name', 'farmer')->first();
        $user->roles()->save($farmer);
        $user->roles;
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $user->roles;
        $user->identity;
        return $user;
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
        $form = $request->all();
        $user = User::find($id);
        $user->fill($form);


        if (isset($form['password'])) {
            $user->password = Hash::make($form['password']);
        }

        $user->save();

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return [true];
    }
}
