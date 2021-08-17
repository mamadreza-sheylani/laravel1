@extends('admin.admin')
@section('title' , 'Order: '.$order->id)
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">شماره سفارش : {{$order->id}}</h5>
            </div>
            <hr>

                <div class="row">
                    <div class="form-group col-md-3">
                        <label>سفارش دهنده</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$order->user->name}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>کد تخفیف</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$order->coupon->code}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>وضعیت</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$order->status_check}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>مبلغ</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$order->total_amount}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>هزینه ارسال</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$order->delivery_amount}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>مبلغ کدتخفیف</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$order->coupon_amount}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>مبلغ پرداختی</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$order->paying_amount}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>نوع پرداخت</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$order->payment_type}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>وضعیت پرداخت</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$order->transactions->status ? 'موفق' : 'ناموفق'}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>تاریخ سفارش</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{verta($order->created_at)}}" disabled>
                    </div>
                    @if ($order->created_at != $order->updated_at)
                    <div class="form-group col-md-3">
                        <label>تاریخ ویرایش</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{verta($order->updated_at)}}" disabled>
                    </div>
                    @endif
                    <div class="form-group col-md-12">
                        <label>توضیحات</label>
                        <textarea class="form-control" type="text" disabled>{{$order->description}}</textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <label>آدرس</label>
                        <textarea class="form-control" type="text" disabled>{{$order->address->address}}</textarea>
                    </div>
                </div>
            <hr>
                <div class="mb-4">
                    <h5 class="font-weight-bold">محصولات :</h5>
                </div>
                <div class="row">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>تصویر محصول</th>
                                <th>نام محصول</th>
                                <th>فی</th>
                                <th>تعداد</th>
                                <th>قیمت کل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderItems as $item)

                            <tr>
                                <td>
                                    <img src="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$item->product->primary_image)}}" alt="" width="80">
                                </td>
                                <td>
                                    <a href="{{route('admin.products.show',['product'=>$item->product->id])}}">{{$item->product->name}}</a>
                                </td>
                                <td>{{number_format($item->price)}}</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{number_format($item->quantity*$item->price)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
        </div>

    </div>

@endsection
