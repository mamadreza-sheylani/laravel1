@extends('admin.admin')

@section('title' , 'Edit coupons')
@section('script')
    <script>
        $(`#expireDate`).MdPersianDateTimePicker({
            targetTextSelector: `#expireInput`,
            englishNumber : true ,
            textFormat : 'yyyy-MM-dd HH:mm' ,
            enableTimePicker : true
            });
    </script>
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold"> ویرایش کوپن <span style="text-decoration: underline;color:#466CD9">{{$coupon->name}}</span></h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{route('admin.coupons.update' , ['coupon'=>$coupon->id])}}" method="POST">
                @csrf
                @method('put')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" value="{{$coupon->name}}" type="text" autocomplete="off" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="code">کد</label>
                        <input class="form-control" id="code" name="code" value="{{$coupon->code}}" type="text" autocomplete="off" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="type">نوع کوپن</label>
                        <select class="form-control" id="type" name="type" >
                            <option value="amount" {{$coupon->type=='amount'?'selected':''}}>مبلغی</option>
                            <option value="precentage"{{$coupon->type=='percentage'?'selected':''}}>درصدی</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="amount">مبلغ</label>
                        <input class="form-control" id="amount" name="amount" value="{{$coupon->amount}}" type="text" autocomplete="off" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="precentage">درصد</label>
                        <input class="form-control" id="precentage" name="precentage" value="{{$coupon->precentage}}" type="text" autocomplete="off" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="max_amount">حداکثر مبلغ درصدی</label>
                        <input class="form-control" id="max_amount" name="max_amount" value="{{$coupon->max_precentage_amount}}" type="text" autocomplete="off" >
                    </div>
                    <div class="form-group col-md-3">
                        <label >تاریخ انقضاء کوپن</label>
                        <div class="input-group">
                            <div class="input-group-prepend order-2">
                                <span class="input-group-text" id="expireDate" >
                                    <i class="fa fa-clock"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" name="expire_at" id="expireInput">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <p style="color: لقسغ;font-size:15px;margin-top:38px">
                            تاریخ قبلی : {{convertEnglishToPersianDate($coupon->expire_at)}}
                        </p>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="5" >{{$coupon->description}}</textarea>
                    </div>
                </div>
                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>

        </div>

    </div>

@endsection
