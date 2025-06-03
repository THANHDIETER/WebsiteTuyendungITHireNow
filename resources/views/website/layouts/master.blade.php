<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Finate - Job Portal Website Template Using Bootstrap 5" />
    <meta name="keywords" content="accessories, digital products, electronic html, modern, products, responsive" />
    <meta name="author" content="hastech" />

    <title>Finate - Job Portal Website Template Using Bootstrap 5</title>

    @include('website.layouts.particals.css')

</head>

<body>

    <!--wrapper start-->
    <div class="wrapper">

        <!--== Start Header Wrapper ==-->
        @include('website.layouts.particals.header')
        <!--== End Header Wrapper ==-->

        @yield('content')

        <!--== Start Footer Area Wrapper ==-->
        @include('website.layouts.particals.footer')
        <!--== End Footer Area Wrapper ==-->

        <!--== Scroll Top Button ==-->
        <div id="scroll-to-top" class="scroll-to-top"><span class="icofont-rounded-up"></span></div>

        <!--== Start Aside Menu ==-->
        @include('website.layouts.particals.aside-menu')
        <!--== End Aside Menu ==-->
    </div>

    <!--=======================Javascript============================-->

    <!--=== jQuery Modernizr Min Js ===-->
    @include('website.layouts.particals.js')

</body>

</html>
