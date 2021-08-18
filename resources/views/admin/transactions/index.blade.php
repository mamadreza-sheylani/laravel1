@extends('admin.admin')
@section('title' , 'Orders Index')
@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست ویژگی ها({{$transactions->total()}})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{route('admin.transactions.create')}}">
                    <i class="fa fa-plus"></i>
                    ایجاد سفارش
                </a>
            </div>
            <table class="table table-btransactioned table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>سفارش دهنده</th>
                        <th>شماره سفارش</th>
                        <th>وضعیت</th>
                        <th>قیمت</th>
                        <th>درگاه پرداخت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $key=> $transaction )
                        <tr>
                            <th>{{$transactions->firstItem()+$key}}</th>
                            <th>{{$transaction->user->name}}</th>
                            <th>{{$transaction->id}}</th>
                            <th class="{{$transaction->status ? 'text-success':'text-danger'}}">
                                {{$transaction->status_check}}
                            </th>
                            <th>
                                {{number_format($transaction->amount)}}
                            </th>
                            <th style="color:{{$transaction->gateway_name['color']}};">
                                {{$transaction->gateway_name['name']}}
                            </th>
                            {{-- <th class="{{$transaction->transactions->status ? 'text-success':'text-danger'}}">
                                {{$transaction->transactions->status ? 'پرداخت شده': 'در انتظار پرداخت'}}
                            </th> --}}
                            <th>
                                <a class="" href="{{route('admin.transactions.show' , ['transaction'=>$transaction->id])}}">
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
