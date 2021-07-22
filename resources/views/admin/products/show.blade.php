@extends('admin.admin')
@section('title' , 'Product: '.$product->name)
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">محصول : {{$product->name}}</h5>
            </div>
            <hr>

                <div class="row">
                    <div class="form-group col-md-3">
                        <label>اسم محصول</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$product->name}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>برند</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$product->brand->name}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>دسته بندی</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$product->category->name}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>وضعیت</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$product->is_active ? 'فعال' : 'غیرفعال'}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>تاریخ عضویت</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{verta($product->created_at)}}" disabled>
                    </div>
                    @if ($product->created_at != $product->updated_at)
                    <div class="form-group col-md-3">
                        <label>تاریخ ویرایش</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{verta($product->updated_at)}}" disabled>
                    </div>
                    @endif
                    <div class="form-group col-md-12">
                        <label >توضیحات</label>
                        <textarea class="form-control" disabled>{{$product->description}}</textarea>
                    </div>

                </div>
                <div>
                    <hr>
                    <p>هزینه ارسال:</p>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>هزینه ارسال</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$product->delivery_amount}}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label>هزینه ارسال به ازای محصول اضافی</label>
                        <input class="form-control" type="text" autocomplete="off" value="{{$product->delivery_amount_per_product}}" disabled>
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
                        <input class="form-control" type="text" autocomplete="off" value="{{$productAttribute->value}}" disabled>
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
                                        <input type="text" disabled class="form-control" value="{{$variation->price}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">تعداد</label>
                                        <input type="text" disabled class="form-control" value="{{$variation->quantity}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">sku</label>
                                        <input type="text" disabled class="form-control" value="{{$variation->sku}}">
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class="form-group col-md-3">
                                        <label for="">قیمت حراجی</label>
                                        <input type="text" disabled class="form-control" value="{{$variation->sale_price ? $variation->sale_price : 'قیمت حراج ندارد'}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">شروع حراج از تاریخ :</label>
                                        <input type="text" disabled class="form-control" value="{{$variation->date_on_sale_from == null ? 'ندارد' : verta($variation->date_on_sale_from)    }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">پایان حراج در تاریخ :</label>
                                        <input type="text" disabled class="form-control" value="{{$variation->date_on_sale_to == null ? 'ندارد' : verta($variation->date_on_sale_to)    }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>

                {{-- for products images --}}
                <div class="col-md-12">
                    <hr>
                    <p>تصاویر محصولات</p>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <img src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image)}}" alt="{{$product->name}}">
                    </div>
                </div>
                <hr>
                <div class="col-md-12">

                    <div class="row">
                        @foreach ($images as $image )
                            <div class="col-md-3">
                                <div class="card">
                                    <img src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $image->image)}}" alt="{{$product->name}}" srcset="" class="card-img-top">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
        </div>

    </div>

@endsection
