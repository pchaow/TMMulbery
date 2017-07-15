<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laratrust\Laratrust;

class HomeController extends Controller
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
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('administrator')) {
            return view('admin.home');
        } elseif ($user->hasRole('farmer')) {
            return $this->farmerHome();
        } else {
            return 'Underconstruction';
        }
    }

    private function farmerHome()
    {
        $user = Auth::user();
        $userId = $user->id;
        $user = User::with(['plants', 'plants.province', 'plants.amphure', 'plants.district'
            , 'amphure', 'district', 'province'])->where('id', $userId)->first();

        foreach ($user->plants as $data) {
            $data->remainingBalance = $data->remainingBalance();
            $data->lastHarvestDate = $data->lastHarvestDate();
            $data->hasTransaction = $data->transactions()->first() != null ? true : false;
        }

        return view('farmer.home')
            ->with('farmer', $user);

    }
}

