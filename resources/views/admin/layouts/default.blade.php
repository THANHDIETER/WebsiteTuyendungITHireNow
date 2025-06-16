<!DOCTYPE html>
<html lang="en">
<head>
  @include('admin.layouts.partials.header')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

  @vite(['resources/js/app.js', 'resources/sass/app.scss'])

  <!-- Navbar -->
  @include('admin.layouts.partials.navbar')

  <!-- Main wrapper: fill height -->
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

  <!-- Footer luôn ở đáy -->
  @include('admin.layouts.partials.footer')
  @include('admin.layouts.partials.confirm-modal')


</body>
</html>
