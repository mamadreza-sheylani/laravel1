@extends('admin.admin')
@section('title' , 'Brands Index')
@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست دسته بندی ها({{$categories->total()}})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{route('admin.categories.create')}}">
                    <i class="fa fa-plus"></i>
                    ایجاد دسته بندی
                </a>
            </div>
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>نام انگلیسی</th>
                        <th>والد</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $key=> $category )
                        <tr>
                            <th>{{$categories->firstItem()+$key}}</th>
                            <th><a href="{{route('admin.categories.show',['category'=>$category->id])}}">{{$category->name}}</a></th>
                            <th>{{$category->slug}}</th>
                            <th>
                                @if ($category->parent_id == 0)
                                بدون والد
                                @else
                                {{$category->parent->name}}
                                @endif
                            </th>
                            <th>
                                <span class="{{$category->getRawOriginal('is_active') ? 'text-success' : 'text-danger'}}">
                                    {{$category->is_active}}
                                </span>
                            </th>
                            <th>
                                <a class="primary mr-3" href="{{route('admin.categories.edit' , ['category'=>$category->id])}}">
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
