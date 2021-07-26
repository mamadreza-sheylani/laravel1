<?php

use App\Models\Coupon;
use App\Models\Order;
use Carbon\Carbon ;
use Darryldecode\Cart\Cart;

function generateFileName($name){

    $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;
        $second = Carbon::now()->second;
        $microsecond = Carbon::now()->microsecond;

        return $year.'_'.$month.'_'.$day.'_'.$second.'_'.$microsecond.'_'.$name ;

}


function convertShamsiToGregorianDate($date)
{
    if($date == null){
        return null;
    }
    $pattern = "/[-\s]/";
    $shamsiDateSplit = preg_split($pattern, $date);

    $arrayGergorianDate = verta()->getGregorian($shamsiDateSplit[0], $shamsiDateSplit[1], $shamsiDateSplit[2]);

    return implode("-", $arrayGergorianDate) . " " . $shamsiDateSplit[3];
}

function convertEnglishToPersianDate($date)
{
    if($date == null){
        return null;
    }
    $pattern = "/[-\s]/";
    $englishDateSplit = preg_split($pattern, $date);

    $arrayPersianDate = verta()->getJalali($englishDateSplit[0], $englishDateSplit[1], $englishDateSplit[2]);

    return $englishDateSplit[3]." ".implode("-", $arrayPersianDate);
}

function checkCoupon($code){

    $coupon = Coupon::where('code' , $code)->where('expire_at','>' ,Carbon::now())->first();
    if($coupon == null){
        return ["error"=>"این کوپن وجود ندارد"];
    }
    if(Order::where('user_id' , auth()->id())->where('coupon_id' , $coupon->id)->where("payment_status" , 1)->exists()){
        return ['error'=>'شما قبلا از این کد تخفیف استفاده کردید'];
    }

    if($coupon->getRawOriginal('type')=="amount"){
        session()->put('coupon' , ['coupon'=>$coupon->code , 'amount' => $coupon->amount]);

    }else{
        $total = \Cart::getTotal();
        $amount = (($total*$coupon->precentage)/100) > $coupon->max_precentage_amount ? $coupon->max_precentage_amount: (($total*$coupon->precentage)/100);
        session()->put('coupon' , ['coupon'=>$coupon->code , 'amount'=>$amount]);
        return ['success'=>'کوپن برای شما اعمال شد'];
    }
}

function cartTotalAmount(){
    if(session()->has('coupon')){
        if(session()->get('coupon.amount')>\Cart::getTotal()){
            return 0;
        }else{
            return \Cart::getTotal() - session()->get('coupon.amount');
        }
    }else{
        return \Cart::getTotal();
    }
}
