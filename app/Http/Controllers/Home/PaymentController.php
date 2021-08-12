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
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        // $data = array(
        //     'MerchantID' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
        //     'Amount' => 10000,
        //     'CallbackURL' => route('home.payment_verify'),
        //     'Description' => 'خرید تست'
        // );


        // $jsonData = json_encode($data);
        // $ch = curl_init('https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentRequest.json');
        // curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/json',
        //     'Content-Length: ' . strlen($jsonData)
        // ));


        // $result = curl_exec($ch);
        // $err = curl_error($ch);
        // $result = json_decode($result, true);
        // curl_close($ch);


        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     if ($result["Status"] == 100) {
        //         //change sandbox to www after account registeration
        //         return redirect()->to('https://sandbox.zarinpal.com/pg/StartPay/'.$result['Authority']);
        //     } else {
        //         echo 'ERR: ' . $result["Status"];
        //     }
        // }
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

        $payGateway = new Pay();
        $payGatewayResult = $payGateway->send($amounts,$request->address_id);
        if (array_key_exists('error', $payGatewayResult)) {
            alert()->error($payGatewayResult['error'], 'دقت کنید')->persistent();
            return redirect()->back();
        }else{
            return redirect()->to($payGatewayResult['success']);
        }


    }

    public function paymentVerify(Request $request)
    {
        // $api = 'test';
        // $token = $request->token;
        // $result = json_decode($this->verify($api, $token));
        // if (isset($result->status)) {
        //     if ($result->status == 1) {
        //         $updateOrder = $this->updateOrder($token, $result->transId);
        //         if (array_key_exists('error', $updateOrder)) {
        //             alert()->error($updateOrder['error'], 'دقت کنید')->persistent('حله');
        //             return redirect()->back();
        //         }
        //         \Cart::clear();
        //         alert()->success(' پرداخت با موفقیت انجام شد.شماره تراکنش'.$result->transId, 'باتشکر')->persistent('حله');
        //         return redirect()->route('home.index');

        //     } else {
        //         alert()->error('پرداخت با خطا مواجه شد.شماره وضعیت'.$result->status, 'باتشکر');
        //         return redirect()->route('home.index');
        //     }
        // } else {
        //     if ($request->status == 0) {
        //         alert()->error('پرداخت با خطا مواجه شد.شماره وضعیت'.$request->status, 'باتشکر');
        //         return redirect()->route('home.index');
        //     }
        // }
        // $MerchantID = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        // $data = array('MerchantID' => $MerchantID, 'Authority' => $request->Authority, 'Amount' => 10000);
        // $jsonData = json_encode($data);
        // //change the url before the depolyment
        // $ch = curl_init('https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentVerification.json');
        // curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/json',
        //     'Content-Length: ' . strlen($jsonData)
        // ));
        // $result = curl_exec($ch);
        // $err = curl_error($ch);
        // curl_close($ch);
        // $result = json_decode($result, true);

        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     if ($result['Status'] == 100) {
        //         echo 'Transation success. RefID:' . $result['RefID'];
        //     } else {
        //         echo 'Transation failed. Status:' . $result['Status'];
        //     }
        // }
        $payGateway = new Pay();
        $payGatewayResult = $payGateway->verify($request->token, $request->status);

        if (array_key_exists('error', $payGatewayResult)) {
            alert()->error($payGatewayResult['error'], 'دقت کنید')->persistent('حله');
            return redirect()->back();
        } else {
            alert()->success($payGatewayResult['success'], 'با تشکر');
            return redirect()->route('home.index');
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
