<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Amphur;
use App\Models\FarmOwner;
use App\Models\Province;
use App\Models\ThailandProvince;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProvinceController extends Controller
{

    public function index(Request $request)
    {
        $provinces = Province::query();
        $provinces->orderBy('name', 'asc')->get();

        if ($request->has('keywords')) {
            $keywords = $request->get('keywords');
            $provinces->where('name', 'LIKE', "%$keywords%");
        }

        return $provinces->get();
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {
        $provinces = Province::with([])->orderBy('name', 'asc')
            ->where("province_id", '=', $id)->first();
        return $provinces;
    }

    public function edit($id)
    {


    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }

}
