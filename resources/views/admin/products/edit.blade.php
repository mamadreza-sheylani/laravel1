@extends('admin.admin')
@section('title' , 'Edit product : '.$product->id )
@section('script')
<script>
        $('#brandSelect').selectpicker({
            'title': 'انتخاب برند'
        });
        $('#tagSelect').selectpicker({
            'title': 'انتخاب تگ'
        });

        $('#categorySelect').selectpicker({
            'title': 'انتخاب دسته بندی'
        });

        //reciving data from $productVariations by json

        let variations = @json($productVariations);

        variations.forEach(variation => {
            $(`#variationDateOnSaleFrom-${variation.id}`).MdPersianDateTimePicker({
            targetTextSelector: `#variationInputDateOnSaleFrom-${variation.id}`,
            englishNumber : true ,
            textFormat : 'yyyy-MM-dd HH:mm' ,
            enableTimePicker : true
            });

            $(`#variationDateOnSaleTo-${variation.id}`).MdPersianDateTimePicker({
            targetTextSelector: `#variationInputDateOnSaleTo-${variation.id}`,
            englishNumber : true ,
            textFormat : 'yyyy-MM-dd HH:mm' ,
            enableTimePicker : true
            });
        });

        $('#variationDateOnSaleFrom').MdPersianDateTimePicker({
        targetTextSelector: '#variationInputDateOnSaleFrom',
        englishNumber : true ,
        textFormat : 'yyyy-MM-dd HH:mm' ,
        enableTimePicker : true
        });

        $('#variationDateOnSaleTo').MdPersianDateTimePicker({
        targetTextSelector: '#variationInputDateOnSaleTo',
        englishNumber : true ,
        textFormat : 'yyyy-MM-dd HH:mm' ,
        enableTimePicker : true
        });
</script>
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ویرایش محصول</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.products.update' , ['product'=>$product->id]) }}" method="POST">
                @csrf
                @method('put')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" value="{{$product->name}}" name="name" type="text" autocomplete="off">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="brand_id">برند</label>
                        <select id="brandSelect" name="brand_id" class="form-control selectpicker" data-live-search="true">
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{$brand->id == $product->brand->id ? 'selected' : ''}}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control selectpicker" id="is_active" name="is_active">
                            <option value="1" {{$product->getRawOriginal('is_active')==1 ? 'selected' : ''}}>فعال</option>
                            <option value="0" {{$product->getRawOriginal('is_active')==1 ? '' : 'selected'}}>غیرفعال</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="tag_ids">تگ ها</label>
                        <select id="tagSelect" name="tag_ids[]" class="form-control selectpicker" multiple data-live-search="true">
                            @php
                                $productTagIds = $product->tags()->pluck('id')->toArray() ;
                            @endphp
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}" {{in_array($tag->id , $productTagIds) ? 'selected' : ''}}>{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" rows="4" id="description" name="description">{{$product->description}}</textarea>
                    </div>
                    {{-- delivery price section --}}
                    <div class="col-md-12">
                        <hr>
                        <p> هزینه ارسال <span class="font-weight-bold" id="deliverPrice"></span></p>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="delivery_amount">هزینه ارسال : </label>
                        <input class="form-control" id="delivery_amount" name="delivery_amount" value="{{$product->delivery_amount}}" type="text" autocomplete="off">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="delivery_amount_per_product">هزینه ارسال به ازای محصول اضافی : </label>
                        <input class="form-control" id="delivery_amount_per_product" name="delivery_amount_per_product" value="{{$product->delivery_amount_per_product}}" type="text" autocomplete="off">
                    </div>
                </div>
                <div>
                    <hr>
                    <p>ویژگی ها :</p>
                </div>
                <div class="row">
                @foreach ($productAttributes as $productAttribute )

                    <div class="form-group col-md-3">
                        <label>{{$productAttribute->attribute->name}}</label>
                        <input class="form-control" type="text" name="attribute_values[{{$productAttribute->id}}]" autocomplete="off" value="{{$productAttribute->value}}" >
                    </div>
                @endforeach
                </div>
                <div class="row">
                    @foreach ($productVariations as $variation )
                        <div class="col-md-12">
                            <hr>
                            <div class="d-flex">
                                <p class="mb-0">قیمت و موجودی برای متغیر ({{$variation->value}})</p>
                                <p class="mb-0 mr-3">
                                    <button class="btn btn-sm btn-primary" type="button" data-toggle='collapse'
                                    data-target='#collapse-{{$variation->id}}'>
                                        نمایش
                                    </button>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="collapse mt-3" id="collapse-{{$variation->id}}" >
                                <div class="card card-body">
                                    <div class="row d-flex justify-content-center">
                                        <div class="form-group col-md-3">
                                            <label for="">قیمت</label>
                                            <input type="text" name="variation_values[{{$variation->id}}][price]"  class="form-control" value="{{$variation->price}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="">تعداد</label>
                                            <input type="text" name="variation_values[{{$variation->id}}][quantity]"  class="form-control" value="{{$variation->quantity}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="">sku</label>
                                            <input type="text" name="variation_values[{{$variation->id}}][sku]"  class="form-control" value="{{$variation->sku}}">
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="form-group col-md-3">
                                            <label for="">قیمت حراجی</label>
                                            <input type="text" name="variation_values[{{$variation->id}}][sale_price]"  class="form-control" value="{{$variation->sale_price ? $variation->sale_price : null}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label >شروع حراج از تاریخ :</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend order-2">
                                                    <span class="input-group-text" id="variationDateOnSaleFrom-{{$variation->id}}" >
                                                        <i class="fa fa-clock"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" name="variation_values[{{$variation->id}}][date_on_sale_from]" id="variationInputDateOnSaleFrom-{{$variation->id}}" value="{{$variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_from) }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="">پایان حراج در تاریخ :</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend order-2">
                                                    <span class="input-group-text" id="variationDateOnSaleTo-{{$variation->id}}" >
                                                        <i class="fa fa-clock"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" name="variation_values[{{$variation->id}}][date_on_sale_to]" id="variationInputDateOnSaleTo-{{$variation->id}}" value="{{$variation->date_on_sale_to == null ? null : verta($variation->date_on_sale_to)    }}">
                                            </div>
                                            {{-- <input type="text" name="variation_values[date_on_sale_to][{{$variation->id}}]"  class="form-control" value="{{$variation->date_on_sale_to == null ? null : verta($variation->date_on_sale_to)    }}"> --}}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
