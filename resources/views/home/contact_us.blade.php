@extends('home.home')
@section('title' , "contact us")
@section('style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
crossorigin=""/>
@endsection
@section('script')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
crossorigin=""></script>
<script>
    var mymap = L.map('map').setView([51.60443674687521, -0.06743514261278798], 13);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
}).addTo(mymap);
var marker = L.marker([51.60443674687521, -0.06743514261278798]).addTo(mymap);
marker.bindPopup("<b>Spurs</b><br>North londen ruller.").openPopup();
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
                        <div id="contact_us_id"></div>
                        <button class="submit" type="submit"> ارسال پیام </button>
                    </form>
                    {!!  GoogleReCaptchaV3::renderOne('contact_us_id','contact_us') !!}
                </div>
            </div>
        </div>
        <div class="contact-map pt-100">
            <div id="map"></div>
        </div>
    </div>
</div>
@endsection
