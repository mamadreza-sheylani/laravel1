<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){
        return view('home.profile.index');
    }

    public function orders(){
        return view('home.profile.orders');
    }

    public function address(){
        return view('home.profile.address');
    }


}
