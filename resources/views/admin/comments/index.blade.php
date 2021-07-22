@extends('admin.admin')
@section('title' , 'Comments Index')
@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست کامنت({{$comments->total()}})</h5>

            </div>
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نویسنده</th>
                        <th>متن</th>
                        <th>وضعیت</th>
                        <th>تاریخ</th>
                        <th>ستاره</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comments as $key=> $comment )
                        <tr>
                            <th>{{$comments->firstItem()+$key}}</th>
                            <th>{{$comment->user->name}}</th>
                            <th>
                                {{$comment->text}}
                            </th>
                            <th>
                                <span class="{{$comment->getRawOriginal('approved') ? 'text-success' : 'text-danger'}}">
                                    {{$comment->approved}}
                                </span>
                            </th>
                            <th>
                                نوشته شده در {{verta($comment->created_at)->format('d-m-Y')}}
                                برای محصول <a href="{{route('admin.products.show' , ['product'=>$comment->product->id])}}">{{$comment->product->name}}</a>
                            </th>
                            <th>
                                {{$comment->rate->rate}}/5
                            </th>
                            <th>
                                @if ($comment->getRaworiginal('approved') == 0)
                                <form action="{{route('admin.comments.update' , ['comment'=>$comment->id])}}" method="post">
                                    @csrf
                                    @method('put')
                                    <button class="btn btn-sm btn-outline-success my-3" type="submit">
                                        تایید کامنت
                                        <i class="fa fa-check"></i>
                                    </button>

                                </form>
                                @else
                                <form action="{{route('admin.comments.destroy' , ['comment'=>$comment->id])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-danger my-3" type="submit">
                                        حذف
                                        <i class="fa fa-trash"></i>
                                    </button>

                                </form>
                                @endif
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
