@extends('admin.admin')

@section('title' , 'New Product')
@section('script')
    <script>
        //for czMore package
        $("#czContainer").czMore();

        $('#categorySelect').selectpicker({
            'title': 'انتخاب دسته بندی'
        });


        $('#attributesContainer').hide();
        //ajax call on category div



        $('#categorySelect').on('changed.bs.select', function () {
            let categoryId = $(this).val();


            //remember to change the Domain name when diploying on a server
            $.get(`{{url('/admin/category-attributes/${categoryId}')}}`,function (response , status) {

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
                        console.log(attribute);
                        attributeFormGroup.append($('<input/>' , {
                            class : 'form-control' ,
                            type  : 'text' ,
                            id  : attribute.name,
                            autocomplete : 'off',
                            name: `attribute_ids[${attribute.id}]` ,

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
                <h5 class="font-weight-bold">بروز رسانی دسته بندی و ویژگی ها : {{$product->name}}
                </h5>
            </div>
            @include('admin.sections.errors')
            <form action="{{ route('admin.products.category.update' , ['product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-row">
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
                                        <option value="{{ $category->id }}" {{$category->id == $product->category->id ? 'selected' : ''}}>{{ $category->name }} - {{$category->parent->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
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
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
