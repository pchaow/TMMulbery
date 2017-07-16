<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\BuyerService;
use App\Http\Services\FarmerService;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BuyerController extends Controller
{
    public function index()
    {
        return view('admin.buyer.index');
    }

    public function create()
    {
        return view('admin.buyer.create');

    }

    public function view($buyerId)
    {

        $buyer = BuyerService::getBuyerByIdWithFullData($buyerId);
       //     $buyer=UserService::getOrderListByUserId($buyerId);
        if ($buyer == null) {
            return redirect("/admin/buyers");
        }

        return view('admin.buyer.view')
            ->with('buyer', $buyer);

    }

    public function edit($userId)
    {
        $user = BuyerService::getBuyerById($userId);

        if ($user == null) {
            return redirect("/admin/buyers");
        }

        return view('admin.buyer.edit')
            ->with('userId', $userId);

    }

}
