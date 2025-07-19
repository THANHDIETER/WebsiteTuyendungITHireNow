<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.partials.header')
    <!-- Gọi app.js và app.scss -->
    @vite(['resources/js/app.js'])
   
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    @include('admin.layouts.partials.navbar')

    <!-- Main wrapper -->
    <div class="flex-grow-1 d-flex flex-column">
        <main class="page-wrapper compact-wrapper flex-grow-1">
            <div class="page-body-wrapper d-flex flex-column flex-grow-1">
                @include('admin.layouts.partials.sidebar')

                <div class="flex-grow-1">
                    @yield('content')
                </div>

                @stack('scripts')
            </div>
        </main>
    </div>

    <!-- Footer + Modal xác nhận -->
    @include('admin.layouts.partials.footer')
    @include('admin.layouts.partials.confirm-modal')

    <!-- <script>
        window.Laravel = {!! json_encode(['userId' => auth()->id()]) !!};
    </script>
    <script>
        window.Laravel = {
            userId: {{ auth()->id() }},
        };
        window.APP_NAME = "{{ config('app.name') }}";
    </script> -->
</body>

</html>
