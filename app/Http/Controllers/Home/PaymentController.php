<?php

namespace App\Http\Controllers\Home;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\PaymentGateWays\Pay;
use App\PaymentGateWays\Zarinpal;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'address_id' => 'required',
            'payment_method' => 'required',
        ]);

        if ($validator->fails()) {
            alert()->error('انتخاب آدرس تحویل سفارش الزامی می باشد', 'دقت کنید')->persistent('حله');
            return redirect()->back();
        }

        $checkCart = $this->checkCart();
        if (array_key_exists('error', $checkCart)) {
            alert()->error($checkCart['error'], 'دقت کنید')->persistent();
            return redirect()->route('home.orders.checkout');
        }

        $amounts = $this->getAmounts();
        if (array_key_exists('error', $amounts)) {
            alert()->error($amounts['error'], 'دقت کنید')->persistent();
            return redirect()->route('home.orders.checkout');
        }
        //chekcing the paying method and gateway
        if($request->payment_method == 'pay'){

            $payGateway = new Pay();
            $payGatewayResult = $payGateway->send($amounts,$request->address_id);
            if (array_key_exists('error', $payGatewayResult)) {
                alert()->error($payGatewayResult['error'], 'دقت کنید')->persistent();
                return redirect()->back();
            }else{
                return redirect()->to($payGatewayResult['success']);
            }
        }else if($request->payment_method == 'zarinpal'){

            $zarinpalGateway = new Zarinpal();
            $zarinpalGatewayResult = $zarinpalGateway->send($amounts , 'خرید تستی' , $request->address_id);
            if (array_key_exists('error', $zarinpalGatewayResult)) {
                alert()->error($zarinpalGatewayResult['error'], 'دقت کنید')->persistent('حله');
                return redirect()->back();
            } else {
                return redirect()->to($zarinpalGatewayResult['success']);
            }
        }else{
            alert()->error('Dont do bad things please Be normal',"something wrong with paying method")->persistent();
            return redirect()->back();
        }



    }

    public function paymentVerify(Request $request)
    {
        //requirement for zarinpal
        $amounts = $this->getAmounts();
        if (array_key_exists('error', $amounts)) {
            alert()->error($amounts['error'], 'دقت کنید')->persistent();
            return redirect()->route('home.orders.checkout');
        }

        if($request->payment_method == 'pay'){

            $payGateway = new Pay();
            $payGatewayResult = $payGateway->verify($request->token, $request->status);

            if (array_key_exists('error', $payGatewayResult)) {
                alert()->error($payGatewayResult['error'], 'دقت کنید')->persistent('حله');
                return redirect()->back();
            } else {
                alert()->success($payGatewayResult['success'], 'با تشکر');
                return redirect()->route('home.index');
            }
        }else if($request->payment_method == 'zarinpal'){

            $zarinpalGateway = new Zarinpal();
            $zarinpalGatewayResult = $zarinpalGateway->verify($request->Authority , $amounts['paying_amount']);
            if (array_key_exists('error', $zarinpalGatewayResult)) {
                alert()->error($zarinpalGatewayResult['error'], 'دقت کنید')->persistent('حله');
                return redirect()->back();
            } else {
                alert()->success($zarinpalGatewayResult['success'], 'با تشکر');
                return redirect()->route('home.index');
            }

        }
    }




    public function checkCart()
    {
        if (\Cart::isEmpty()) {
            return ['error' => 'سبد خرید شما خالی می باشد'];
        }

        foreach (\Cart::getContent() as $item) {
            $variation = ProductVariation::find($item->attributes->id);

            $price = $variation->is_sale ? $variation->sale_price : $variation->price;

            if ($item->price != $price) {
                \Cart::clear();
                return ['error' => 'قیمت محصول تغییر پیدا کرد'];
            }

            if ($item->quantity > $variation->quantity) {
                \Cart::clear();
                return ['error' => 'تعداد محصول تغییر پیدا کرد'];
            }

            return ['success' => 'success!'];
        }
    }

    public function getAmounts()
    {
        if (session()->has('coupon')) {
            $checkCoupon = checkCoupon(session()->get('coupon.code'));
            if (array_key_exists('error', $checkCoupon)) {
                return $checkCoupon;
            }
        }

        return [
            'total_amount' => (\Cart::getTotal() + cartTotalSaleAmount()),
            'delivery_amount' => 8000,
            'coupon_amount' => session()->has('coupon') ? session()->get('coupon.amount') : 0,
            'paying_amount' => cartTotalAmount()
        ];
    }

}
