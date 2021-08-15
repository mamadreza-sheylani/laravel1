@extends('admin.admin')
@section('title' , 'Orders Index')
@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست ویژگی ها({{$orders->total()}})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{route('admin.orders.create')}}">
                    <i class="fa fa-plus"></i>
                    ایجاد سفارش
                </a>
            </div>
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>سفارش دهنده</th>
                        <th>شماره سفارش</th>
                        <th>وضعیت</th>
                        <th>قیمت</th>
                        <th>نوع پرداخت</th>
                        <th> وضعیت پرداخت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key=> $order )
                        <tr>
                            <th>{{$orders->firstItem()+$key}}</th>
                            <th>{{$order->user->name}}</th>
                            <th>{{$order->id}}</th>
                            <th class="{{$order->status ? 'text-success':'text-danger'}}">
                                {{$order->status ? 'پرداخت شده':'در انتظار پرداخت'}}
                            </th>
                            <th>
                                {{number_format($order->paying_amount)}}
                            </th>
                            <th>
                                {{$order->payment_type?'انلاین':'افلاین'}}
                            </th>
                            <th class="{{$order->transactions->status ? 'text-success':'text-danger'}}">
                                {{$order->transactions->status ? 'پرداخت شده': 'در انتظار پرداخت'}}
                            </th>
                            <th>
                                <a class="" href="{{route('admin.orders.show' , ['order'=>$order->id])}}">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
