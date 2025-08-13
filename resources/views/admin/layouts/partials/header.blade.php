<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
    content="Edmin admin is super flexible, powerful, clean &amp; modern responsive bootstrap admin template with unlimited possibilities.">
<meta name="keywords"
    content="admin template, Edmin admin template, best javascript admin, dashboard template, bootstrap admin template, responsive admin template, web app">
<meta name="author" content="pixelstrap">
<meta name="csrf-token" content="{{ csrf_token() }}">


<title>{{ $title ?? 'Admin' }}</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle (kèm Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<!-- Favicon icon-->
<link rel="icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">
<!-- Google font-->
<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
    rel="stylesheet">
<!-- Font awesome icon css -->

<!-- Ico Icon css -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}">
<!-- Flag Icon css -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
<!-- Themify Icon css -->
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/css/vendors/themify-icons/themify-icons/css/themify.css') }}">
<!-- Animation css -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css/animate.css') }}">
<!-- Whether Icon css-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/weather-icons/css/weather-icons.min.css') }}">
<!-- Apex Chart css-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/apexcharts.css') }}">
<!-- Data Table css-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/simple-datatables/dist/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}">
<!-- App css-->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
<style>
    .svg-color {
        color: #000;
        transition: color 0.3s ease;
    }

    html.dark .svg-color {
        color: #ddd;
    }
</style>

<meta property="og:url" content="{{ url()->current() }}">


<header class="page-header row justify-content-between align-items-center bg-white">

    <div class="logo-wrapper d-flex align-items-center col-4" style="padding-left: 80px; ">
        <div class="d-flex justify-content-center align-items-center" style="height: 70px; width: 90px;">
            @php
                $logo = \App\Models\Logo::where('type', 'admin')->where('is_active', true)->first();
            @endphp

            <a href="{{ route('home') }}">
                <img src="{{ $logo ? asset('storage/' . $logo->image_path) : asset('images/default.png') }}"
                    alt="Admin Logo" class="logo-img" style="height:120px;">
            </a>
        </div>

        <a class="close-btn ms-4" href="javascript:void(0)">
            <div class="toggle-sidebar">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </a>
    </div>
    <div class="page-main-header d-flex align-items-center col-auto">
        <div class="nav-right">
            <ul class="header-right list-unstyled d-flex align-items-center gap-3 mb-0">

                <!-- Dark mode toggle -->
                <li class="modes d-flex">
                    <a href="#" class="dark-mode text-dark" title="Chế độ tối">
                        <i class="bi bi-moon-fill svg-color fs-5"></i>
                    </a>
                </li>

                <!-- Trang chủ -->
                <li class="modes d-flex">
                    <a href="{{ route('home') }}" class="text-dark" title="Trang chủ">
                        <i class="bi bi-house-door-fill svg-color fs-5"></i>
                    </a>
                </li>

                <!-- Nhà tuyển dụng -->
                <li class="modes d-flex">
                    <a href="{{ route('employer') }}" class="text-dark" title="Nhà tuyển dụng">
                        <i class="bi bi-person-badge svg-color fs-5"></i>
                    </a>
                </li>



                <!-- Profile dropdown -->
                <li class="profile-dropdown custom-dropdown position-relative">
                    <div class="d-flex align-items-center gap-2 p-2 bg-light rounded">
                        <img loading="lazy" src="{{ asset('assets/images/profile.png') }}" alt="Profile"
                            class="rounded-circle" width="36" height="36">
                        <div>
                            <h6 class="mb-0 fw-semibold">
                                @if (auth()->check())
                                    {{ auth()->user()->name }}
                                    <sup class="text-danger" style="font-size: 0.7em;">{{ auth()->user()->id }}</sup>
                                @else
                                    <span class="text-muted">Guest</span>
                                @endif
                            </h6>
                            <small class="text-muted">
                                @if (auth()->check())
                                    {{ auth()->user()->role }}
                                @else
                                    Chưa đăng nhập
                                @endif
                            </small>
                        </div>
                    </div>

                    <!-- Dropdown menu -->
                    <div class="custom-menu overflow-hidden shadow mt-2 bg-white rounded position-absolute end-0 z-3">
                        <ul class="list-unstyled m-0 p-2">
                            <li>
                                <a href="{{ route('home') }}"
                                    class="d-flex align-items-center px-3 py-2 text-decoration-none text-dark rounded menu-link">
                                    <i class="bi bi-person-circle me-2 fs-5"></i>
                                    <span>Trang chủ</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('employer') }}"
                                    class="d-flex align-items-center px-3 py-2 text-decoration-none text-dark rounded menu-link">
                                    <i class="bi bi-chat-square-text me-2 fs-5"></i>
                                    <span>Trang nhà tuyển dụng</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>


</header>
@if (session('access_token'))
    <script>
        localStorage.setItem('access_token', "{{ session('access_token') }}");
    </script>
@endif
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const profileDropdown = document.querySelector('.profile-dropdown');
        const customMenu = profileDropdown.querySelector('.custom-menu');

        profileDropdown.addEventListener('click', function (e) {
            e.stopPropagation();
            customMenu.classList.toggle('d-none');
        });

        document.addEventListener('click', function () {
            customMenu.classList.add('d-none');
        });
    });
</script>

<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const darkModeBtn = document.querySelector('.dark-mode');
        if (darkModeBtn) {
            darkModeBtn.addEventListener('click', function (e) {
                e.preventDefault();
                document.documentElement.classList.toggle('dark');
                // Lưu trạng thái vào localStorage để giữ trạng thái khi reload
                if (document.documentElement.classList.contains('dark')) {
                    localStorage.setItem('theme', 'dark');
                } else {
                    localStorage.setItem('theme', 'light');
                }
            });
        }
        // Auto load theme nếu đã lưu
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    });

    // Notification realtime Pusher + Echo
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '1ea633f39dfb08c3c0c2',
        cluster: 'ap1',
        forceTLS: true,
    });

    const userId = {{ auth()->id() }};
    if (userId && window.Echo) {
        window.Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                // Tăng số badge
                const notiCount = document.getElementById('noti-count');
                if (notiCount) {
                    let count = parseInt(notiCount.textContent) || 0;
                    notiCount.textContent = count + 1;
                    notiCount.style.display = 'inline-block';
                }
                // Thêm notification mới vào dropdown
                const notiList = document.getElementById('noti-list');
                if (notiList) {
                    // Xoá dòng "Không có thông báo mới" nếu có
                    let emptyLi = notiList.querySelector('.text-muted');
                    if (emptyLi) notiList.removeChild(emptyLi);

                    // Tạo thông báo mới
                    const li = document.createElement('li');
                    li.className = 'd-flex align-items-center b-l-primary';
                    li.setAttribute('data-id', notification.id);
                    li.innerHTML = `
                        <div class="flex-grow-1">
                            <span>Vừa xong</span>
                            <a href="${notification.link_url}">
                                <h5>${notification.message}</h5>
                            </a>
                            <h6>{{ config('app.name') }}</h6>
                        </div>
                        <div class="flex-shrink-0">
                            <img class="b-r-15 img-40" src="{{ asset('assets/images/avatar/default.jpg') }}" alt="">
                        </div>
                    `;
                    // Chèn notification mới lên đầu
                    notiList.insertBefore(li, notiList.firstChild);

                    // Giữ tối đa 5 notification mới nhất (trước nút AllNotification)
                    let notiItems = notiList.querySelectorAll('li[data-id]');
                    if (notiItems.length > 5) {
                        notiList.removeChild(notiItems[notiItems.length - 1]);
                    }
                }
            });
    }
</script>