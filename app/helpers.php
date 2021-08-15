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

function convertEnglishToPersianDate($date,$wantHour=true)
{
    if($date == null){
        return null;
    }
    $pattern = "/[-\s]/";
    $englishDateSplit = preg_split($pattern, $date);

    $arrayPersianDate = verta()->getJalali($englishDateSplit[0], $englishDateSplit[1], $englishDateSplit[2]);
    if ($wantHour==true) {
        return $englishDateSplit[3]." ".implode("-", $arrayPersianDate);
    }else{
        return implode('/',$arrayPersianDate);
    }
}

function cartTotalSaleAmount()
{
    $cartTotalSaleAmount = 0;
    foreach (\Cart::getContent() as $item) {
        if ($item->attributes->is_sale) {
            $cartTotalSaleAmount += $item->quantity * ($item->attributes->price - $item->attributes->sale_price);
        }
    }

    return $cartTotalSaleAmount;
}

function checkCoupon($code){

    $coupon = Coupon::where('code' , $code)->where('expire_at','>' ,Carbon::now())->first();

    if($coupon == null){
        //session()->forget('coupon');
        return ["error"=>"این کوپن وجود ندارد"];
    }

    if (Order::where('user_id', auth()->id())->where('coupon_id', $coupon->code)->where('payment_status', 1)->exists()) {
        session()->forget('coupon');
        return ['error' => 'شما قبلا از این کد تخفیف استفاده کرده اید'];
    }
    if($coupon->getRawOriginal('type')=="amount"){
        session()->put('coupon' , ['id'=>$coupon->id,'code'=>$coupon->code , 'name'=>$coupon->name, 'amount' => $coupon->amount]);
    }else{
        $total = \Cart::getTotal();
        $amount = (($total*$coupon->precentage)/100) > $coupon->max_precentage_amount ? $coupon->max_precentage_amount: (($total*$coupon->precentage)/100);
        session()->put('coupon' , ['id'=>$coupon->id,'code'=>$coupon->code , 'name'=>$coupon->name,'amount'=>$amount]);
    }
    return ['success'=>'کوپن برای شما اعمال شد'];
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
