@extends('admin.admin')

@section('title' , 'New Product')
@section('script')
    <script>
        //for czMore package
        $("#czContainer").czMore();

        $('#categorySelect').selectpicker({
            'title': 'انتخاب دسته بندی'
        });

        $('#brandSelect').selectpicker({
            'title': 'انتخاب برند'
        });
        $('#tagSelect').selectpicker({
            'title': 'انتخاب تگ'
        });

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

        $('#attributesContainer').hide();
        //ajax call on category div



        $('#categorySelect').on('changed.bs.select', function () {
            let categoryId = $(this).val();


            //remember to change the Domain name when diploying on a server
            $.get(`{{url('/admin-panel/management/category-attributes/${categoryId}')}}`,function (response , status) {

                if(status == 'success'){

                    $('#attributesContainer').fadeIn();

                    //empty attribute container
                    $('#attributes').find('div').remove();

                    //Create attribute inputs and Appending
                    response.attributes.forEach(attribute => {
                        let attributeFormGroup = $('<div/>' ,{
                            class : 'form-group col-md-3',
                        })

                        attributeFormGroup.append($('<label/>' ,{
                            for : attribute.name,
                            text : attribute.name
                        }));

                        attributeFormGroup.append($('<input/>' , {
                            class : 'form-control' ,
                            type  : 'text' ,
                            id  : attribute.name,
                            autocomplete : 'off',
                            name: `attribute_ids[${attribute.id}]`
                        }));

                        //final appending
                        $('#attributes').append(attributeFormGroup);

                    });

                    $('#variationName').text(response.variation.name);



                }else{
                    alert('error in a thing');
                }

            }).fail(function(){
                    alert('error in reciving attributes list');
            });

        });

    </script>
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ایجاد محصول جدید
                </h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" autocomplete="off">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="brand_id">برند</label>
                        <select id="brandSelect" name="brand_id" class="form-control selectpicker" data-live-search="true">
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control selectpicker" id="is_active" name="is_active">
                            <option value="1">فعال</option>
                            <option value="0">غیرفعال</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="tag_ids">تگ ها</label>
                        <select id="tagSelect" name="tag_ids[]" class="form-control selectpicker" multiple data-live-search="true">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    {{-- product image section --}}
                    <div class="col-md-12">
                        <hr>
                        <p>تصاویر محصول</p>
                    </div>
                    <div class="form-group col-md-3"> {{--primary image--}}
                        <label for="primary_image">انتخاب تصویر اصلی</label>
                        <div class="custom-file">
                            <input type="file" name="primary_image" id="primary_image" class="custom-file-input">
                            <label for="primary_image" class="custom-file-label">انتخاب فایل</label>
                        </div>
                    </div>
                    {{-- secondary images --}}
                    <div class="form-group col-md-3">
                        <label for="images">انتخاب تصویر ها</label>
                        <div class="custom-file">
                            <input type="file" name="images[]" id="images" class="custom-file-input" multiple>
                            <label for="images" class="custom-file-label">انتخاب فایل</label>
                        </div>
                    </div>
                    {{-- Category and Attribute Section --}}
                    <div class="col-md-12">
                        <hr>
                        <p>دسته بندی و ویژگی ها :</p>
                    </div>

                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="form-group col-md-3">
                                <label for="category_id">دسته بندی</label>
                                <select id="categorySelect" name="category_id" class="form-control selectpicker" data-live-search="true">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }} - {{$category->parent->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- ajax call response container --}}
                    <div id="attributesContainer" class="col-md-12">
                        {{-- appending attributes --}}
                        <div class="row justify-content-center" id="attributes"></div>


                        <div class="col-md-12">
                            <hr>
                            <p>افزودن قیمت برای متغیر : <span class="font-weight-bold" id="variationName"></span></p>
                        </div>
                        <div id="czContainer">
                            <div id="first">
                                <div class="recordset">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="value">نام</label>
                                            <input class="form-control" name="variation_values[value][]" type="text" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="value">قیمت</label>
                                            <input class="form-control" name="variation_values[price][]" type="text" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="value">تعداد</label>
                                            <input class="form-control" name="variation_values[quantity][]" type="text" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="value">SKU : کد انبار</label>
                                            <input class="form-control" name="variation_values[sku][]" type="text" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Delivery Price Section --}}
                    <div class="col-md-12">
                        <hr>
                        <p> هزینه ارسال : <span class="font-weight-bold" id="deliverPrice"></span></p>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="delivery_amount">هزینه ارسال : </label>
                        <input class="form-control" id="delivery_amount" name="delivery_amount" type="text" autocomplete="off">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="delivery_amount_per_product">هزینه ارسال به ازای محصول اضافی : </label>
                        <input class="form-control" id="delivery_amount_per_product" name="delivery_amount_per_product" type="text" autocomplete="off">
                    </div>

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
