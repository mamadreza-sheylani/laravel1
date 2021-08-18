@extends('home.home')
@section('title' , "about us")
@section('content')
<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="index.html">صفحه ای اصلی</a>
                </li>
                <li class="active"> در باره ما </li>
            </ul>
        </div>
    </div>
</div>

<div class="about-story-area pt-100 pb-100" style="direction: rtl;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="story-img">
                    <a href="#"><img src="{{asset('images/home/abou-us.jpg')}}" alt="" loading="lazy"></a>
                </div>
            </div>
            <div class="col-lg-6 text-right">
                <div class="story-details pl-50">
                    <div class="story-details-top">
                        <h2> خوش آمدید به  <span> MyShop</span></h2>
                        <p>
                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
                        </p>
                    </div>
                    <div class="story-details-bottom">
                        <h4> لورم ایپسوم متن ساختگی </h4>
                        <p>
                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
                        </p>
                    </div>
                    <div class="story-details-bottom">
                        <h4> لورم ایپسوم متن ساختگی </h4>
                        <p>
                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="feature-area" style="direction: rtl;">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="single-feature text-right mb-40">
                    <div class="feature-icon">
                        <img src="{{asset('images/home/free-shipping.png')}}" alt="" />
                    </div>
                    <div class="feature-content">
                        <h4>از اینجا تا آبودان</h4>
                        <p>ارسال تا جایی که پای انسان رسیده</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="single-feature text-right mb-40 pl-50">
                    <div class="feature-icon">
                        <img src="{{asset('images/home/support.png')}}" alt="" />
                    </div>
                    <div class="feature-content">
                        <h4>گوش به زنگ</h4>
                        <p>ما همیشه انلاینیم اگه شک داری 3 شب زنگ بزن</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="single-feature text-right mb-40">
                    <div class="feature-icon">
                        <img src="{{asset('images/home/security.png')}}" alt="" />
                    </div>
                    <div class="feature-content">
                        <h4>دیوار بتنی</h4>
                        <p>امن امن بدون هیچ حباب امنیتی :)))))</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
