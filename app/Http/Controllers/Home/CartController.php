<?php

namespace App\Http\Controllers\Home;


use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Http\Controllers\Controller;
use Cart;

class CartController extends Controller
{
    public function index(){
        $cart = Cart::getContent();
        return view('home.cart.index' , compact('cart'));
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

        dd($rowId);

    }

}
// errors are for Cart there are not real errors
