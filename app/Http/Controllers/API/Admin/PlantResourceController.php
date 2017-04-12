<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\PlantRequest;
use App\Http\Requests\UserRequest;
use App\Models\Plant;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PlantResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Plant::query();
        $query->with(['user', 'province', 'amphure', 'district']);

        if ($request->has('keyword')) {
            $keyword = $request->get('keyword');
//            $query->orWhere('email', 'LIKE', "%$keyword%");
//            $query->orWhere('username', 'LIKE', "%$keyword%");
//            $query->orWhere('name', 'LIKE', "%$keyword%");

        }
        $query->with('user');
        return $query->paginate();
    }


    public function show($id)
    {
        $plant = Plant::query();
        $plant->where('id', $id);
        $plant->with(['user', 'province', 'amphure', 'district']);

        return $plant->first();
    }
}
