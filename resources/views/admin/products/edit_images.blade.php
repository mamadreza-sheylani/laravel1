@extends('admin.admin')

@section('title' , 'Edit Product Images of : '.$product->name)
@section('script')
    <script>
         $('#primary_image').change(function(){
            var fileName = $(this).val() ;
            //replacing with new file name
            $(this).next('.custom-file-label').html(fileName);
        });
        $('#images').change(function(){
            var fileName = $(this).val() ;
            //replacing with new file name
            $(this).next('.custom-file-label').html(fileName);
        })
    </script>
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            @include('admin.sections.errors')
            <div class="mb-4">
                <h5>ویرایش تصاویر محصول :
                    <span class="font-weight-bold" ><a href="{{route('admin.products.show' , ['product'=>$product->id])}}">{{$product->name}}</a></span>
                </h5>
            </div>
            <hr>
            <div class="col-12 col-md-12">
                <h4>تصویر اصلی :</h4>
            </div>
            <div class="col-12 col-md-12 mb-4">
                <div class="row p-2">
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image)}}" class="card-img-top" alt="{{$product->name}}">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-md-12">
                <h4>تصاویر :</h4>
            </div>

            <div class="col-12 col-md-12 mb-4">
                <div class="row">
                    @foreach ($images as $image )
                    <div class="col-md-3 pl-4">
                        <div class="card">
                            <img src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $image->image)}}" class="card-img-top" alt="{{$product->name}}">
                            <div class="card-body text-center">
                                <form action="{{route('admin.products.images.destroy' , ['product' => $product->id])}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="image_id" value="{{$image->id}}">
                                    <button type="submit" class="btn btn-outline-danger btn-sm mb-2">
                                        حذف
                                    </button>
                                </form>
                                <form action="{{route('admin.products.images.set_primary' , ['product'=>$product->id])}}" method="POST">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="image_id" value="{{$image->id}}">
                                    <button type="submit" class="btn btn-outline-secondary btn-sm" >
                                        انتخاب به عنوان عکس اصلی
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-12 mb-4 mt-2">
                <hr>
                <h4>
                    آپلود تصاویر جدید :
                </h4>
            </div>
            <form action="{{route('admin.products.images.add' , ['product' => $product->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="col-md-12 col-12 mt-2">
                    <div class="d-flex row">
                        <div class="form-group col-md-4"> {{--primary image--}}
                            <label for="primary_image">انتخاب تصویر اصلی</label>
                            <div class="custom-file">
                                <input type="file" name="primary_image" id="primary_image" class="custom-file-input">
                                <label for="primary_image" class="custom-file-label">انتخاب فایل</label>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="images">انتخاب تصویر ها</label>
                            <div class="custom-file">
                                <input type="file" name="images[]" id="images" class="custom-file-input" multiple>
                                <label for="images" class="custom-file-label">انتخاب فایل</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex row">
                        <button type="submit" class="btn btn-primary mt-4 m-2">ثبت ویرایش</button>
                        <a href="{{route('admin.products.index')}}" class="btn btn-outline-secondary  mt-4 p-2 m-2">برگشت</a>
                    </div>
                </div>
            </form>

        </div>

    </div>

@endsection
