<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $sliders = Banner::where('type' , 'slider')->orderBy('priority')->get();
        $index_top_banners = Banner::where('type' , 'index-top')->orderBy('priority')->get();
        $bottom_banners = Banner::where('type' , 'bottom-banner')->orderBy('priority')->get();
        $products = Product::where('is_active' , 1)->get()->take(5);
        return view('home.index' , compact('sliders' , 'index_top_banners' , 'bottom_banners' , 'products'));
    }
}
