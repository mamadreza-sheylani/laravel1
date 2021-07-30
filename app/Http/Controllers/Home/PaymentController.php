<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request){
        dd($request->all());
    }

    public function checkCart(){
        if(\Cart::isEmpty()){
            return ['error'=>'سبد خرید شما خالی می باشد .'];
            return redirect()->route('home.index');
        }

        foreach(\Cart::getContent() as $item){
            $variation = ProductVariation::find($item->attributes->id);
            $price = $variation->is_sale ? $variation->sale_price : $variation->price;
            if($item->price != $price){
                \Cart::clear();
                return ['error' => 'قیمت محصول تغییر کرده است.'];
            }

            if($item->quantity != $variation->quantity){
                \Cart::clear();
                return ['error' => 'موجودی محصول تغییر کرده است.'];
            }

            return ['success' , 'success!'];
        }
    }

    public function getAmounts(){

        if(session()->has('coupon')){

        }
        $checkCoupon = checkCoupon();
        if(array_key_exists('error' , $checkCoupon)){
            return $checkCoupon;
        }

        // return [
        //     'total_amount'=> ,
        //     'delivery_amount' => ,
        //     'coupon_amount' => ,
        //     'paying_amount' => ,

        // ]
    }
}
