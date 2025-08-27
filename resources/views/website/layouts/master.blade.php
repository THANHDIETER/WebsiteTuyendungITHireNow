<!DOCTYPE html>
<html lang="vi">

<head>
    @include('website.layouts.particals.css')
</head>
<body>
    @vite(['resources/js/web.js'])

    <!--wrapper start-->
    <div class="wrapper">

        <!--== Bắt đầu Header ==-->
        @include('website.layouts.particals.header')

        @yield('content')

        <!--== Bắt đầu Footer ==-->
        @include('website.layouts.particals.footer')

        <!--== Nút cuộn lên đầu trang ==-->
        <div id="scroll-to-top" class="scroll-to-top"><span class="icofont-rounded-up"></span></div>

        <!--== Bắt đầu Menu bên ==-->
        @include('website.layouts.particals.aside-menu')
    </div>

    <!--=== jQuery Modernizr Min Js ===-->
    @include('website.layouts.particals.js')
    @include('chat')

</body>

</html>