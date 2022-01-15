@extends('admin.admin')
@section('title' , 'Brand: '.$brand->name)
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">برند : {{$brand->name}}</h5>
            </div>
            <hr>

                <div class="row">
                    <div class="form-group col-md-3">
                        <label>نام</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$brand->name}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>وضعیت</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$brand->is_active}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>تاریخ عضویت</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{verta($brand->created_at)}}" disabled>
                    </div>
                    @if ($brand->created_at != $brand->updated_at)
                    <div class="form-group col-md-3">
                        <label>تاریخ ویرایش</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{verta($brand->updated_at)}}" disabled>
                    </div>
                    @endif

                </div>

                <a href="{{ route('admin.brands.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
        </div>

    </div>

@endsection
