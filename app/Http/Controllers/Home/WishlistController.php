<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function add(Product $product){

        $in_wishlist = Wishlist::where('user_id' , auth()->user()->id)->where('product_id' , $product->id)->first();
        if (!$in_wishlist) {

            Wishlist::create([
                'user_id'=>auth()->user()->id,
                'product_id'=>$product->id
            ]);

            alert()->success(null , 'Added To Wishlist')->persistent('Ok');
            return redirect()->back();
        }else{
            alert()->info('This Product Is Allready In Your Wishlist','Sorry')->persistent('AH Ok');
            return redirect()->back();
        }



    }

    public function remove(Product $product){
        $wishlist = $product->checkUserWishlist(auth()->user()->id , $product->id);
        if ($wishlist) {
            Wishlist::where('user_id' , auth()->user()->id)->where('product_id' , $product->id)->delete();
            alert()->success('Product Removed From Your Wishlist' , 'Product Removed')->persistent("ok");
            return redirect()->back();
        }else{
            alert()->error('Something Went Wrong During Deleting Product Form Wishlist' , 'Try Again')->persistent("ok");
            return redirect()->back();
        }
    }

    public function index(Wishlist $wishlist){
        $in_wishlist = Wishlist::where('user_id' , auth()->user()->id)->latest()->get();
        // dd($wishlist->product()->wishlist);
        return view('home.profile.wishlist' , compact('in_wishlist'));
    }

}
