@extends('admin.admin')
@section('title' , 'Users Index')
@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست کاربران({{$users->total()}})</h5>
                <a class="btn btn-sm btn-outline-primary disabled" href="{{route('admin.users.create')}}">
                    <i class="fa fa-plus"></i>
                    ایجاد برند
                </a>
            </div>
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>وضعیت</th>
                        <th>تاریخ ثبت نام</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key=> $user )
                        <tr>
                            <th>{{$key+1}}</th>
                            <th>{{$user->name}}</th>
                            <th>
                                {{-- this part is in Brand model (getIsActiveAttribute) --}}
                                <span class="{{$user->getRawOriginal('status')==1 ? 'text-success' : 'text-danger'}}">
                                    {{$user->status == 1 ? "فعال" : "غیرفعال"}}
                                </span>
                            </th>
                            <th>
                                {{$user->created_at}}
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
