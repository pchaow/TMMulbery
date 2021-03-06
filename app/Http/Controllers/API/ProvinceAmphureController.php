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

class ProvinceAmphureController extends Controller
{

    public function index($provinceId)
    {
        if ($provinceId == 0) return [];
        /* @var Province $province */
        $province = Province::find($provinceId);
        $amphurs = $province->amphures()->get();
        return $amphurs;
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show($provinceId, $id)
    {
        if ($provinceId == 0) return [];
        $province = Province::find($provinceId);
        $amphur = $province->amphurs()->where('AMPHUR_ID', '=', $id)->first();
        return $amphur;
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
