<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request,Category $category){

        $products = $category->products()->filter()->search()->paginate(15);

        $attributes = $category->attribute()->where('is_filter' , 1)->with('values')->get();
        $variation = $category->attribute()->where('is_variation' , 1)->with('variationValues')->first();
        // $products = Product::latest()->paginate(12);
        return view('home.categories.show' , compact('category' , 'attributes' , 'variation' , 'products'));
    }
}
