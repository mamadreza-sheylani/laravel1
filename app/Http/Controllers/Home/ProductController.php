<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product){

        $comments = Comment::where('product_id' , $product->id)->where('approved' , 1)->latest()->get();
        return view('home.products.show' , compact('product' ,'comments' ));
    }
}
