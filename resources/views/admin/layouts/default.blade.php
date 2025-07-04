<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.partials.header')

    <!-- Chỉ cần giữ lại MỘT đoạn script để truyền dữ liệu -->
    <script>
        window.Laravel = {
            userId: {{ auth()->check() ? auth()->id() : 'null' }},
        };
        window.APP_NAME = "{{ config('app.name') }}";
    </script>

    <!-- Gọi app.js và app.scss -->
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])

    <!-- Font Awesome & Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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

    <script>
        window.Laravel = {!! json_encode(['userId' => auth()->id()]) !!};
    </script>
    <script>
        window.Laravel = {
            userId: {{ auth()->id() }},
        };
        window.APP_NAME = "{{ config('app.name') }}";
    </script>
</body>

</html>
