@extends('admin.admin')
@section('title' , 'Coupons Index')
@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست کوپن ها ({{$coupons->total()}})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{route('admin.coupons.create')}}">
                    <i class="fa fa-plus"></i>
                    ایجاد کوپن
                </a>
            </div>
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان</th>
                        <th>کد</th>
                        <th>نوع</th>
                        <th>تاریخ انقضا</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupons as $key=> $coupon )
                        <tr>
                            <th>{{$coupons->firstItem()+$key}}</th>
                            <th><a href="{{route('admin.coupons.show' , ['coupon'=>$coupon->id])}}">{{$coupon->name}}</a></th>
                            <th>{{$coupon->code}}</th>
                            <th>{{$coupon->what_type}}</th>
                            <th>
                                ساخته شده در {{verta($coupon->created_at)->format('d-m-Y')}}
                            </th>
                            <th>
                                <a class="btn btn-sm btn-outline-primary mr-3" href="{{route('admin.coupons.edit' , ['coupon'=>$coupon->id])}}">
                                    ویرایش
                                    <i class="fa fa-edit"></i>
                                </a>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
