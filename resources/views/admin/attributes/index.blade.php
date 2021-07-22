@extends('admin.admin')
@section('title' , 'Brands Index')
@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست ویژگی ها({{$attributes->total()}})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{route('admin.attributes.create')}}">
                    <i class="fa fa-plus"></i>
                    ایجاد ویژگی
                </a>
            </div>
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attributes as $key=> $attribute )
                        <tr>
                            <th>{{$attributes->firstItem()+$key}}</th>
                            <th>{{$attribute->name}}</th>
                            <th>
                                {{-- this part is in Brand model (getIsActiveAttribute) --}}
                                {{-- <span class="{{$brand->getRawOriginal('is_active') ? 'text-success' : 'text-danger'}}">
                                    {{$brand->is_active}}
                                </span> --}}
                                ساخته شده در {{verta($attribute->created_at)->format('d-m-Y')}}
                            </th>
                            <th>
                                <a class="btn btn-sm btn-outline-success" href="{{route('admin.attributes.show' , ['attribute'=>$attribute->id])}}">
                                    نمایش
                                    <i class="fa fa-search"></i>
                                </a>
                                <a class="btn btn-sm btn-outline-primary mr-3" href="{{route('admin.attributes.edit' , ['attribute'=>$attribute->id])}}">
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
