@extends('admin.admin')
@section('title' , 'Brand: '.$tag->name)
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">تگ : {{$tag->name}}</h5>
            </div>
            <hr>

                <div class="row">
                    <div class="form-group col-md-3">
                        <label>اسم تگ</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$tag->name}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>تاریخ عضویت</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{verta($tag->created_at)}}" disabled>
                    </div>
                    @if ($tag->created_at != $tag->updated_at)
                    <div class="form-group col-md-3">
                        <label>تاریخ ویرایش</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{verta($tag->updated_at)}}" disabled>
                    </div>
                    @endif

                </div>

                <a href="{{ route('admin.tags.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
        </div>

    </div>

@endsection
