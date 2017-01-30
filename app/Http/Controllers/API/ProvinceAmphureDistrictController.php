<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Amphur;
use App\Models\Amphure;
use App\Models\FarmOwner;
use App\Models\Province;
use App\Models\ThailandProvince;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProvinceAmphureDistrictController   extends Controller
{

    public function index($provinceId, $amphureId)
    {
        /* @var Amphur $amphur */
        $amphur = Amphure::find($amphureId);
        $districts = $amphur->districts()->get();
        return $districts;
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {

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
