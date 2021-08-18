@extends('home.home')
@section('title' , "contact us")
@section('content')
<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="index.html">صفحه ای اصلی</a>
                </li>
                <li class="active">فروشگاه </li>
            </ul>
        </div>
    </div>
</div>

<div class="contact-area pt-100 pb-100">
    <div class="container">
        <div class="row text-right" style="direction: rtl;">
            <div class="col-lg-5 col-md-6">
                <div class="contact-info-area">
                    <h2> ارتباط با ما </h2>
                    <p>
                        برای ارتباط با ما کافی است که هیچ وقت با ما ارتباط نگیرید زمانه سختی شده جواب دادن هم.
                    </p>
                    <div class="contact-info-wrap">
                        <div class="single-contact-info">
                            <div class="contact-info-icon">
                                <i class="sli sli-location-pin"></i>
                            </div>
                            <div class="contact-info-content">
                                <p> فلان منطقه از کره زمین جایی که اردکا صدا ندارن </p>
                            </div>
                        </div>
                        <div class="single-contact-info">
                            <div class="contact-info-icon">
                                <i class="sli sli-envelope"></i>
                            </div>
                            <div class="contact-info-content">
                                <p><a href="mailto:mamadrezasheylani@gmail.com">mamadrezasheylani@gmail.com</a></p>
                            </div>
                        </div>
                        <div class="single-contact-info">
                            <div class="contact-info-icon">
                                <i class="sli sli-screen-smartphone"></i>
                            </div>
                            <div class="contact-info-content">
                                <p style="direction: ltr;"> 0911 111 1111 </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-6">
                <div class="contact-from contact-shadow">
                    <form id="contact-form" action="{{route('home.contact_us.send')}}" method="post">
                        @csrf
                        <input name="name" type="text" placeholder="نام شما" autocomplete="off" required>
                        <input name="email" type="email" placeholder="ایمیل شما" autocomplete="off" required>
                        <input name="subject" type="text" placeholder="موضوع پیام" autocomplete="off" required>
                        <textarea name="text" placeholder="متن پیام" required></textarea>
                        <button class="submit" type="submit"> ارسال پیام </button>
                    </form>
                    <p class="form-messege"></p>
                </div>
            </div>
        </div>
        <div class="contact-map pt-100">
            <div id="map"></div>
        </div>
    </div>
</div>
@endsection
