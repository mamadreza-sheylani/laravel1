@extends('admin.admin')
@section('title' , 'Tags Index')
@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست تگ ها({{$tags->total()}})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{route('admin.tags.create')}}">
                    <i class="fa fa-plus"></i>
                    ایجاد تگ جدید
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
                    @foreach ($tags as $key=> $tag )
                        <tr>
                            <th>{{$tags->firstItem()+$key}}</th>
                            <th>{{$tag->name}}</th>
                            <th>
                                {{-- this part is in Brand model (getIsActiveAttribute) --}}
                                {{-- <span class="{{$brand->getRawOriginal('is_active') ? 'text-success' : 'text-danger'}}">
                                    {{$brand->is_active}}
                                </span> --}}
                                ساخته شده در {{verta($tag->created_at)->format('d-m-Y')}}
                            </th>
                            <th>
                                <a class="btn btn-sm btn-outline-success" href="{{route('admin.tags.show' , ['tag'=>$tag->id])}}">
                                    نمایش
                                    <i class="fa fa-search"></i>
                                </a>
                                <a class="btn btn-sm btn-outline-primary mr-3" href="{{route('admin.tags.edit' , ['tag'=>$tag->id])}}">
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
