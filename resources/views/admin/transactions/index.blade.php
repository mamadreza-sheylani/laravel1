@extends('admin.admin')
@section('title' , 'Transactions Index')
@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست تراکنش ها({{$transactions->total()}})</h5>

            </div>
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>کاربر</th>
                        <th>شماره سفارش</th>
                        <th>Ref_ID</th>
                        <th>قیمت</th>
                        <th>درگاه پرداخت</th>
                        <th>وضعیت</th>
                        {{-- <th>عملیات</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $key=> $transaction )
                        <tr>
                            <th>{{$transactions->firstItem()+$key}}</th>
                            <th>{{$transaction->user->name}}</th>
                            <th>{{$transaction->order->id}}</th>
                            <th>{{$transaction->ref_id}}</th>
                            <th>
                                {{number_format($transaction->amount)}}
                            </th>
                            <th style="color:{{$transaction->gateway_name['color']}};">
                                {{$transaction->gateway_name['name']}}
                            </th>

                            <th class="{{$transaction->getRawOriginal('status') ? 'text-success':'text-danger'}}">
                                {{$transaction->status}}
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
