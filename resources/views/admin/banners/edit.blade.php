@extends('admin.admin')

@section('title' , 'Edit Banner : '.$banner->title)
@section('script')
    <script>
        //for czMore package
        $('#banner_image').change(function(){
            var fileName = $(this).val() ;
            //replacing with new file name
            $(this).next('.custom-file-label').html(fileName);
        });

        $('#is_active').selectpicker({
            'title': 'انتخاب وضعیت'
        });
    </script>
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5>ویرایش بنر :
                    <span class="font-weight-bold" >{{$banner->image}}</span>
                </h5>
            </div>
            <hr>
            <div class="col-md-6 col-xl-6 col-6 mb-4 text-center mx-auto d-block">
                <img src="{{url((env('PRODUCT_BANNER_IMAGES_UPLOAD_PATH').$banner->image))}}" alt="" class="img-fluid rounded ">
            </div>
            @include('admin.sections.errors')
            <form action="{{ route('admin.banners.update' , ['banner'=>$banner->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-row">
                    <div class="form-group col-md-3"> {{--primary image--}}
                        <label for="banner_image">انتخاب تصویر بنر</label>
                        <div class="custom-file">
                            <input type="file" name="banner_image" id="banner_image" class="custom-file-input">
                            <label for="banner_image" class="custom-file-label">انتخاب فایل</label>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="title">عنوان</label>
                        <input class="form-control" id="title" name="title" type="text" autocomplete="off" value="{{$banner->title}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="text">متن</label>
                        <input class="form-control" id="text" name="text" type="text" value="{{$banner->text}}" autocomplete="off">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="priority">الویت</label>
                        <input class="form-control" id="priority" name="priority" value="{{$banner->priority}}" type="text" autocomplete="off">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control selectpicker" id="is_active" name="is_active">
                            <option value="1" {{$banner->getRawOriginal('is_active')==1 ? 'selected' : ''}}>فعال</option>
                            <option value="0" {{$banner->getRawOriginal('is_active')==1 ? '' : 'selected'}}>غیرفعال</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="banner_type">نوع بنر</label>
                        <input class="form-control" id="banner_type" name="banner_type" type="text" value="{{$banner->type}} "autocomplete="off">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="button_text">متن دکمه</label>
                        <input class="form-control" id="button_text" name="button_text" value="{{$banner->button_text}}" type="text" autocomplete="off">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="button_link"> لینک دکمه</label>
                        <input class="form-control" id="button_link" name="button_link" type="text" value="{{$banner->button_link}}" autocomplete="off">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="button_icon">آیکون دکمه</label>
                        <input class="form-control" id="button_icon" name="button_icon" type="text" value="{{$banner->button_icon}}" autocomplete="off">
                    </div>



                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
