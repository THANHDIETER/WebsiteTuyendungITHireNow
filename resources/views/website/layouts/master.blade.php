<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Finate - Nền tảng việc làm & tuyển dụng sử dụng Bootstrap 5" />
    <meta name="keywords" content="việc làm, tuyển dụng, website việc làm, hiện đại, responsive, tìm việc" />
    <meta name="author" content="hastech" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>HireNow - Nền tảng tuyển dụng IT hiện đại</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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