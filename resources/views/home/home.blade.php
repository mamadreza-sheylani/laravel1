<!DOCTYPE html>
<html class="no-js" lang="fa">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Rebuild Your Style With Us">
    <meta name="author" content="Dario inc.">

    <title>@yield('title')</title>

    <!-- Custom styles for this template-->
    <link href="{{ asset('/css/home.css') }}" rel="stylesheet">
    @yield('style')

</head>

<body>

    {{-- @yield('content') --}}
    <div class="wrapper">
        @include('home.sections.loader')

        @include('home.sections.header')

        @yield('content')

        @include('home.sections.footer')

        @include('home.sections.mobile-canvas')


    </div>


    <!-- JavaScript-->
    <script src="{{ asset('/js/home/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('/js/home/plugins.js') }}"></script>
    <script src="{{ asset('/js/home.js') }}"></script>

    @include('sweet::alert')

    @yield('script')
    {!!  GoogleReCaptchaV3::init() !!}
</body>

</html>
