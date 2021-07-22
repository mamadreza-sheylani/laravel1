@extends('admin.admin')
@section('title' , 'Banner Index')
@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="d-flex flex-column flex-md-row text-center justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3">لیست بنر ها({{$banners->total()}})</h5>
                <div>
                    <a class="btn btn-sm btn-outline-primary" href="{{route('admin.banners.create')}}">
                        <i class="fa fa-plus"></i>
                        ایجاد بنر جدید
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان</th>
                            <th>متن بنر</th>
                            <th>نوع بنر</th>
                            <th>الویت</th>
                            <th>متن دکمه</th>
                            <th>لینک دکمه</th>
                            <th>آیکون دکمه</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banners as $key=> $banner )
                            <tr>
                                <th>{{$banners->firstItem()+$key}}</th>
                                <th>
                                    <a target="_blank" href="{{url(env('PRODUCT_BANNER_IMAGES_UPLOAD_PATH').$banner->image)}}">{{$banner->title}}</a>
                                </th>
                                <th>
                                    {{$banner->text}}
                                </th>
                                <th>
                                    {{$banner->type}}
                                </th>
                                <th>
                                    {{$banner->priority}}
                                </th>
                                <th>
                                    {{$banner->button_text}}
                                </th>
                                <th>
                                    <a href="{{$banner->button_link}}">{{$banner->button_link}}</a>
                                </th>
                                <th>
                                    <i class="{{$banner->button_icon}}" ></i>
                                </th>
                                <th>
                                    <span class="{{$banner->getRawOriginal('is_active') ? 'text-success' : 'text-danger'}}">
                                        {{$banner->is_active}}
                                    </span>
                                </th>
                                <th>
                                    <form action="{{route('admin.banners.destroy' , ['banner' => $banner->id])}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" >
                                            حذف
                                            <i class="fa fa-trash" ></i>
                                        </button>
                                    </form>
                                    <a href="{{route('admin.banners.edit' , ['banner' => $banner->id])}}" class="btn btn-sm btn-outline-primary m-2">
                                        ویرایش
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{$banners->render()}}
            </div>
        </div>
    </div>
@endsection
