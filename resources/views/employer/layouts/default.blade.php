<!DOCTYPE html>
<html lang="en">

<head>

    @include('employer.layouts.partials.header')
    @if (session('access_token'))
        <script>
            localStorage.setItem('access_token', "{{ session('access_token') }}");
        </script>
    @endif
</head>

<body class="d-flex flex-column min-vh-100">

    @vite(['resources/js/app.js', 'resources/sass/app.scss'])

    <!-- Navbar -->
    @include('employer.layouts.partials.navbar')

    <!-- Main wrapper: fill height -->
    <div class="flex-grow-1 d-flex flex-column">
        <main class="page-wrapper compact-wrapper flex-grow-1">
            <div class="page-body-wrapper d-flex flex-column flex-grow-1">
                @include('employer.layouts.partials.sidebar')

                <div class="flex-grow-1">
                    @yield('content')
                </div>

                @stack('scripts')
            </div>
        </main>
    </div>

    <!-- Footer luôn ở đáy -->
    @include('employer.layouts.partials.footer')
    @include('employer.layouts.partials.confirm-modal')

    <script>
        window.Laravel = {!! json_encode(['userId' => auth()->id()]) !!};
    </script>

</body>

</html>
