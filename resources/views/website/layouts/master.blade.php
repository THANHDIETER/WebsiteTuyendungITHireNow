<!DOCTYPE html>
<html lang="vi">

<head>
    @include('website.layouts.particals.css')
</head>
<body>
    @vite(['resources/js/web.js'])

    <div class="wrapper">

        @include('website.layouts.particals.header')

        @yield('content')

        @include('website.layouts.particals.footer')

        <div id="scroll-to-top" class="scroll-to-top"><span class="icofont-rounded-up"></span></div>

        @include('website.layouts.particals.aside-menu')
    </div>

    @include('website.layouts.particals.js')
    @include('chat')

</body>

</html>