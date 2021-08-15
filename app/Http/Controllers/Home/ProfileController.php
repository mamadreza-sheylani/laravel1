<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){
        return view('home.profile.index');
    }

    public function orders(){
        $user_orders = Order::where('user_id',auth()->user()->id)->get();
        return view('home.profile.orders',compact('user_orders'));
    }

    public function address(){
        return view('home.profile.address');
    }


}
