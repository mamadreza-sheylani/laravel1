@extends('home.home')
@section('title')
Profile &#8226; {{auth()->user()->name}} &#8226; Addresses
@endsection
@section('script')
    <script>
        $('.province-select').change(function() {

            var provinceID = $(this).val();

            if (provinceID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-province-cities-list') }}?province_id=" + provinceID,
                    success: function(res) {
                        if (res) {
                            $(".city-select").empty();

                            $.each(res, function(key , city) {
                                console.log(city);
                                $(".city-select").append('<option value="' + city.id + '">' +
                                    city.name + '</option>');
                            });

                        } else {
                            $(".city-select").empty();
                        }
                    }
                });
            } else {
                $(".city-select").empty();
            }
        });
    </script>
@endsection
@section('content')

<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="index.html">صفحه ای اصلی</a>
                </li>
                <li class="active"> آدرس ها </li>
            </ul>
        </div>
    </div>
</div>

<!-- my account wrapper start -->
<div class="my-account-wrapper pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- My Account Page Start -->
                <div class="myaccount-page-wrapper">
                    <!-- My Account Tab Menu Start -->
                    <div class="row text-right" style="direction: rtl;">
                        <div class="col-lg-3 col-md-4">
                            @include('home.sections.profile_sidebar')
                        </div>
                        <!-- My Account Tab Menu End -->
                        <!-- My Account Tab Content Start -->
                        <div class="col-lg-9 col-md-8">
                            <div class="myaccount-content address-content">
                                <h3> آدرس ها </h3>

                                <div>
                                    <address>
                                        <p>
                                            <strong> علی شیخ </strong>
                                            <span class="mr-2"> عنوان آدرس : <span> منزل </span> </span>
                                        </p>
                                        <p>
                                            خ شهید فلان ، کوچه ۸ فلان ،فرعی فلان ، پلاک فلان
                                            <br>
                                            <span> استان : تهران </span>
                                            <span> شهر : تهران </span>
                                        </p>
                                        <p>
                                            کدپستی :
                                            89561257
                                        </p>
                                        <p>
                                            شماره موبایل :
                                            89561257
                                        </p>

                                    </address>
                                    <a href="#" class="check-btn sqr-btn collapse-address-update">
                                        <i class="sli sli-pencil"></i> ویرایش آدرس
                                    </a>

                                    <div class="collapse-address-update-content">

                                        <form action="#">

                                            <div class="row">

                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        عنوان
                                                    </label>
                                                    <input type="text" required="" name="title">
                                                    @error('title')
                                                        <p class="input-error-validation">
                                                            {{$message}}
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        شماره تماس
                                                    </label>
                                                    <input type="text">
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        استان
                                                    </label>
                                                    <select class="email s-email s-wid">
                                                        <option>Bangladesh</option>
                                                        <option>Albania</option>
                                                        <option>Åland Islands</option>
                                                        <option>Afghanistan</option>
                                                        <option>Belgium</option>
                                                    </select>
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        شهر
                                                    </label>
                                                    <select class="email s-email s-wid">
                                                        <option>Bangladesh</option>
                                                        <option>Albania</option>
                                                        <option>Åland Islands</option>
                                                        <option>Afghanistan</option>
                                                        <option>Belgium</option>
                                                    </select>
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        آدرس
                                                    </label>
                                                    <input type="text">
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        کد پستی
                                                    </label>
                                                    <input type="text">
                                                </div>

                                                <div class=" col-lg-12 col-md-12">
                                                    <button class="cart-btn-2" type="submit"> ویرایش
                                                        آدرس
                                                    </button>
                                                </div>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                                <hr>

                                <button class="collapse-address-create mt-3" type="submit"> ایجاد آدرس
                                    جدید </button>
                                <div class="collapse-address-create-content"
                                    style="{{count($errors->addressStore)>0 ? 'display:block;' : ''}}"
                                >

                                    <form action="{{route('home.profile.address.store')}}" method="POST">
                                        @csrf
                                        <div class="row">

                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    عنوان
                                                </label>
                                                <input type="text" autocomplete="off" name="title" value="{{old('title')}}">
                                                @error('title' , 'addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{$message}}</strong>
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    شماره تماس
                                                </label>
                                                <input type="text" name="cellphone" autocomplete="off" value="{{old('cellphone')}}">
                                                @error('cellphone' , 'addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{$message}}</strong>
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    استان
                                                </label>
                                                <select class="email s-email s-wid province-select" name="province_id">
                                                    <option>--انتخاب کنید</option>
                                                    @foreach ($provinces as $province)
                                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    شهر
                                                </label>
                                                <select class="email s-email s-wid city-select" name="city_id">
                                                </select>
                                            </div>
                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    آدرس
                                                </label>
                                                <input type="text" name="address" autocomplete="off" value="{{old('postal_code')}}">
                                                @error('address' , 'addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{$message}}</strong>
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    کد پستی
                                                </label>
                                                <input type="text" name="postal_code" autocomplete="off" value="{{old('postal_code')}}">
                                                @error('postal_code' , 'addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{$message}}</strong>
                                                    </p>
                                                @enderror
                                            </div>

                                            <div class=" col-lg-12 col-md-12">

                                                <button class="cart-btn-2" type="submit"> ثبت آدرس
                                                </button>
                                            </div>



                                        </div>

                                    </form>

                                </div>

                            </div>
                        </div> <!-- My Account Tab Content End -->
                    </div>
                </div> <!-- My Account Page End -->
            </div>
        </div>
    </div>
</div>
<!-- my account wrapper end -->

@endsection
