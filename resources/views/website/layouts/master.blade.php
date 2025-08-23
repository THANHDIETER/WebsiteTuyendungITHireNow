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
        <!--== Kết thúc Header ==-->

        @yield('content')

        <!--== Bắt đầu Footer ==-->
        @include('website.layouts.particals.footer')
        <!--== Kết thúc Footer ==-->

        <!--== Nút cuộn lên đầu trang ==-->
        <div id="scroll-to-top" class="scroll-to-top"><span class="icofont-rounded-up"></span></div>

        <!--== Bắt đầu Menu bên ==-->

        @include('website.layouts.particals.aside-menu')
        <!--== Kết thúc Menu bên ==-->
    </div>

    <!--=======================Javascript============================-->
    <!--=== jQuery Modernizr Min Js ===-->
    @include('website.layouts.particals.js')
    @include('chat')
    @stack('scripts')

    @yield('scripts') <!-- 🔥 THÊM DÒNG NÀY -->
</body>

</html>