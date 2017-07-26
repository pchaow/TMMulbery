<?php

namespace App\Http\Controllers;

use App\Http\Services\BuyerService;
use App\Http\Services\FarmerService;
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
        }

        if ($user->hasRole('buyer')) {
            return redirect("/buyer");
        }

        if ($user->hasRole('farmer')) {
            return redirect('/farmer');
        }

    }

}

