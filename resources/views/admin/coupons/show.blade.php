@extends('admin.admin')

@section('title' , 'New coupons')
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">کوپن <span style="text-decoration: underline;color:#466CD9">{{$coupon->name}}</span></h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="name">نام</label>
                    <input class="form-control" id="name" value="{{$coupon->name}}" type="text" autocomplete="off" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="code">کد</label>
                    <input class="form-control" id="code" value="{{$coupon->code}}" type="text" autocomplete="off" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="type">نوع کوپن</label>
                    <select class="form-control" id="type" disabled>
                        <option value="amount" {{$coupon->type=='amount'?'selected':''}}>مبلغی</option>
                        <option value="precentage"{{$coupon->type=='percentage'?'selected':''}}>درصدی</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="amount">مبلغ</label>
                    <input class="form-control" id="amount" value="{{$coupon->amount}}" type="text" autocomplete="off" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="precentage">درصد</label>
                    <input class="form-control" id="precentage" value="{{$coupon->precentage}}" type="text" autocomplete="off" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="max_amount">حداکثر مبلغ درصدی</label>
                    <input class="form-control" id="max_amount" value="{{$coupon->max_precentage_amount}}" type="text" autocomplete="off" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label >تاریخ انقضاء کوپن</label>
                    <div class="input-group">
                        <div class="input-group-prepend order-2">
                            <span class="input-group-text" id="expireDate">
                                <i class="fa fa-clock"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control"  id="expireInput" value="{{$coupon->expire_at}}" disabled>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label for="description">توضیحات</label>
                    <textarea class="form-control" name="description" id="description" cols="30" rows="5" disabled>{{$coupon->description}}</textarea>
                </div>
            </div>
            {{-- <a href="{{route('admin.coupons.edit' , ['coupon'=>$coupon->id])}}" class="btn btn-outline-primary mt-5" type="submit">ویرایش</a> --}}
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>

        </div>

    </div>

@endsection
