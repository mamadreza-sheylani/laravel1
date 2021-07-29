<?php

namespace App\Http\Controllers\Home;


use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Province;
use Cart;

class CartController extends Controller
{
    public function index(){
        $cart = Cart::getContent();
        return $cart;
        //return view('home.cart.index' , compact('cart'));
    }


    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qtybutton' => 'required'
        ]);

        $product = Product::find($request->product_id);
        $productVariation = ProductVariation::findOrFail(json_decode($request->variation)->id);

        // $productVariation ? dd('true') : dd('false');

        if ($request->qtybutton > $productVariation->quantity) {
            alert()->error('تعداد وارد شده از محصول درست نمی باشد', 'دقت کنید');
            return redirect()->back();
        }

        $rowId = $product->id . '-' . $productVariation->id;

        if (Cart::get($rowId) == null) {
            Cart::add(array(
                'id' => $rowId,
                'name' => $product->name,
                'price' => $productVariation->is_sale ? $productVariation->sale_price : $productVariation->price,
                'quantity' => $request->qtybutton,
                'attributes' => $productVariation->toArray(),
                'associatedModel' => $product
            ));
        } else {
            alert()->warning('محصول مورد نظر به سبد خرید شما اضافه شده است', 'دقت کنید');
            return redirect()->back();
        }

        alert()->success('محصول مورد نظر به سبد خرید شما اضافه شد', 'باتشکر');
        return redirect()->back();
    }

    public function update(Request $request){
        $request->validate([
            'qtybutton' => 'required',
        ]);

        foreach($request->qtybutton as $rowId => $qauntity){

            $item = Cart::get($rowId);

            if ($qauntity > $item->attributes->quantity) {
                alert()->error(null , "number you selected is out of stuck");
                return redirect()->back();
            }
            Cart::update($rowId, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $qauntity
                )
              ));
        }
    }

    public function remove($rowId){

        Cart::remove($rowId);
        alert()->success('You removed 1 item from your cart' , 'Removed Item');
        return redirect()->back();

    }

    public function clear(){
        Cart::clear();
        alert()->warning('You Deleted Your Cart' , 'Deleted Cart');
        return redirect()->back();
    }

    public function checkCoupon(Request $request){
        $request->validate([
            'code'=>'required'
        ]);

        //using a helper written in helper.php
        $result = checkCoupon($request->code);
        if(array_key_exists('error' , $result)){
            alert()->warning($result['error'] , 'Coupon Not Found');
        }else{
            alert()->success($result['success'] , 'Coupen Submited');
        }
        return redirect()->back();
        //dd($result);

    }

    public function checkout(){
        if(\Cart::isEmpty()){
            alert()->info("return and add some items to your cart please" , "Cart Is Empty");
            return redirect()->back();
        }
        $cart=Cart::getContent();
        $user_addresses =  auth()->user()->user_addresses;
        $provinces = Province::all();
        return view('home.cart.checkout' , compact('cart' , 'user_addresses','provinces'));
    }

}
// errors are for Cart there are not real errors
