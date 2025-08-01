<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
    content="Edmin admin is super flexible, powerful, clean &amp; modern responsive  admin template with unlimited possibilities.">
<meta name="keywords"
    content="admin template, Edmin admin template, best javascript admin, dashboard template,  admin template, responsive admin template, web app">
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
<link rel="stylesheet" href="{{ asset('assets/css/vendors/%40fortawesome/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/vendors/%40fortawesome/fontawesome-free/css/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/vendors/%40fortawesome/fontawesome-free/css/brands.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/vendors/%40fortawesome/fontawesome-free/css/solid.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/vendors/%40fortawesome/fontawesome-free/css/regular.css') }}">
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
<meta property="og:url" content="{{ url()->current() }}">

<header class="page-header row justify-content-between align-items-center bg-white">
    <div class="logo-wrapper d-flex align-items-center col-4">
   <a href="{{ route('home') }}">
    @php
        $clientLogo = \App\Models\Logo::where('type', 'header')->where('is_active', true)->first();
    @endphp

    <img 
        src="{{ $clientLogo ? asset('storage/' . $clientLogo->image_path) : asset('images/default.png') }}"
        alt="Client Logo"
        style="height: 120px;" {{-- hoặc dùng class --}}
    >
</a>


    <a class="close-btn" href="javascript:void(0)">
        <div class="toggle-sidebar">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>

        </div>
    </a>
</div>

    <div class="page-main-header d-flex align-items-center col-auto">
       
        <div class="nav-right">
            <ul class="header-right">
                <li class="modes d-flex"><a class="dark-mode">
                        <!-- Icon Moon -->
                        <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a></li>
                <li class="serchinput d-lg-none d-flex"><a class="search-mode">
                        <!-- Icon Search -->
                        <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <div class="form-group search-form">
                        <input type="text" placeholder="Search here...">
                    </div>
                </li>
                <!-- Notification menu -->
                <li class="custom-dropdown">
                    <a href="{{ route('notifications.index') }}" id="notification-toggle">
                        <!-- Icon Bell -->
                        <svg class="svg-color circle-color" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M13.73 21a2 2 0 01-3.46 0" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <span class="badge rounded-pill badge-secondary" id="noti-count">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>


                    {{-- <div class="custom-menu notification-dropdown py-0 overflow-hidden">
                        <h5 class="title bg-primary-light">
                            Notifications
                            <a href="{{ route('notifications.index') }}">
                                <span class="font-primary">View</span>
                            </a>
                        </h5>
                        <ul class="activity-update" id="noti-list">
                            <li class="mt-3 d-flex justify-content-center">
                                <div class="button-group">
                                    <a class="btn btn-secondary" href="">AllNotification</a>
                                </div>
                            </li>
                        </ul>
                    </div> --}}
                </li>

                <!-- Bookmark menu-->
                <li class="custom-dropdown"><a href="javascript:void(0)">
                        <!-- Icon Star -->
                        <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <polygon points="12 2 15 9 22 9 17 14 19 21 12 17 5 21 7 14 2 9 9 9" stroke="currentColor"
                                stroke-width="2" stroke-linejoin="round" fill="none" />
                        </svg>
                    </a>
                    <div class="custom-menu bookmark-dropdown py-0 overflow-hidden">
                        <h5 class="title bg-primary-light">Bookmark</h5>
                        <ul>
                            <li>
                                <form class="mb-3">
                                    <div class="input-group">
                                        <input class="form-control" type="text" placeholder="Search Bookmark..."><span
                                            class="input-group-text">
                                            <!-- Icon Search -->
                                            <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </div>
                                </form>
                            </li>
                            <li class="d-flex align-items-center bg-light-primary">
                                <div class="flex-shrink-0 me-2"><a href="">
                                        <!-- Icon Home -->
                                        <svg class="svg-color stroke-primary" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 12l9-9 9 9v9a3 3 0 01-3 3H6a3 3 0 01-3-3v-9z"
                                                stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                            <path d="M9 21V12h6v9" stroke="currentColor" stroke-width="2"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a></div>
                                <div class="d-flex justify-content-between align-items-center w-100"><a
                                        href="">Dashboard</a>
                                    <svg class="svg-color icon-star" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <polygon points="12 2 15 9 22 9 17 14 19 21 12 17 5 21 7 14 2 9 9 9"
                                            stroke="currentColor" stroke-width="2" stroke-linejoin="round"
                                            fill="none" />
                                    </svg>
                                </div>
                            </li>
                            <li class="d-flex align-items-center bg-light-secondary">
                                <div class="flex-shrink-0 me-2"><a href="">
                                        <!-- Icon Pie -->
                                        <svg class="svg-color stroke-secondary" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                                            <path d="M12 2v10h10" stroke="currentColor" stroke-width="2"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a></div>
                                <div class="d-flex justify-content-between align-items-center w-100"><a
                                        href="">To-do</a>
                                    <svg class="svg-color icon-star" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <polygon points="12 2 15 9 22 9 17 14 19 21 12 17 5 21 7 14 2 9 9 9"
                                            stroke="currentColor" stroke-width="2" stroke-linejoin="round"
                                            fill="none" />
                                    </svg>
                                </div>
                            </li>
                            <li class="d-flex align-items-center bg-light-tertiary">
                                <div class="flex-shrink-0 me-2"><a href="">
                                        <!-- Icon Chart -->
                                        <svg class="svg-color stroke-tertiary" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 3v18h18" stroke="currentColor" stroke-width="2"
                                                stroke-linejoin="round" />
                                            <path d="M18 15l-5-5-4 4-3-3" stroke="currentColor" stroke-width="2"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a></div>
                                <div class="d-flex justify-content-between align-items-center w-100"><a
                                        href="">Chart</a>
                                    <svg class="svg-color icon-star" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <polygon points="12 2 15 9 22 9 17 14 19 21 12 17 5 21 7 14 2 9 9 9"
                                            stroke="currentColor" stroke-width="2" stroke-linejoin="round"
                                            fill="none" />
                                    </svg>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- Cart menu-->
                <li class="custom-dropdown"><a href="javascript:void(0)">
                        <!-- Icon Bag -->
                        <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 2l3 0a3 3 0 016 0l3 0a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z"
                                stroke="currentColor" stroke-width="2" stroke-linejoin="round" fill="none" />
                            <path d="M6 10h12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </a>
                    <div class="custom-menu cart-dropdown py-0 overflow-hidden">
                        <h5 class="title bg-primary-light">Cart<span>Total : <span
                                    class="font-primary">4350.9</span></span></h5>
                        <ul>
                            <li class="cartbox d-flex bg-light-primary">
                                <div class="flex-shrink-0 border-primary"><img loading="lazy"
                                        src="{{ asset('assets/images/dashboard2/product/1.png') }}" alt="">
                                </div>
                                <div class="touchpin-details"><a href="">
                                        <h5>Apple Computers</h5>
                                    </a><span>$2600.00</span>
                                    <div class="touchspin-wrapper">
                                        <button class="decrement-touchspin btn-touchspin">
                                            <!-- Icon Minus -->
                                            <svg class="svg-color" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <line x1="5" y1="12" x2="19" y2="12" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                        <input class="form-control input-touchspin bg-light-primary" type="number"
                                            value="5">
                                        <button class="increment-touchspin btn-touchspin">
                                            <!-- Icon Plus -->
                                            <svg class="svg-color" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <line x1="12" y1="5" x2="12" y2="19" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" />
                                                <line x1="5" y1="12" x2="19" y2="12" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                    </div>
                                    <button class="btn btn-close"></button>
                                </div>
                            </li>
                            <li class="cartbox d-flex bg-light-secondary">
                                <div class="flex-shrink-0 border-secondary"><img loading="lazy"
                                        src="{{ asset('assets/images/dashboard2/product/2.png') }}" alt="">
                                </div>
                                <div class="touchpin-details"><a href="">
                                        <h5>Microwave</h5>
                                    </a><span>$1450.45</span>
                                    <div class="touchspin-wrapper">
                                        <button class="decrement-touchspin btn-touchspin">
                                            <!-- Icon Minus -->
                                            <svg class="svg-color" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <line x1="5" y1="12" x2="19" y2="12" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                        <input class="form-control input-touchspin bg-light-secondary" type="number"
                                            value="5">
                                        <button class="increment-touchspin btn-touchspin">
                                            <!-- Icon Plus -->
                                            <svg class="svg-color" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <line x1="12" y1="5" x2="12" y2="19" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" />
                                                <line x1="5" y1="12" x2="19" y2="12" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                    </div>
                                    <button class="btn btn-close"></button>
                                </div>
                            </li>
                            <li class="cartbox d-flex bg-light-tertiary">
                                <div class="flex-shrink-0 border-tertiary"><img loading="lazy"
                                        src="{{ asset('assets/images/dashboard2/product/3.png') }}" alt="">
                                </div>
                                <div class="touchpin-details"><a href="">
                                        <h5>Mackup Kit</h5>
                                    </a><span>$300.45</span>
                                    <div class="touchspin-wrapper">
                                        <button class="decrement-touchspin btn-touchspin">
                                            <!-- Icon Minus -->
                                            <svg class="svg-color" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <line x1="5" y1="12" x2="19" y2="12" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                        <input class="form-control input-touchspin bg-light-tertiary" type="number"
                                            value="5">
                                        <button class="increment-touchspin btn-touchspin">
                                            <!-- Icon Plus -->
                                            <svg class="svg-color" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <line x1="12" y1="5" x2="12" y2="19" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" />
                                                <line x1="5" y1="12" x2="19" y2="12" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                    </div>
                                    <button class="btn btn-close"></button>
                                </div>
                            </li>
                            <li class="mt-3 p-0 d-flex justify-content-center">
                                <div><a class="btn btn-secondary" href="">Checkout</a></div>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- tin nhắn chat-->
                <li class="custom-dropdown"><a href="{{ route('chat.index') }}">
                        <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h12a2 2 0 012 2z" stroke="currentColor"
                                stroke-width="2" stroke-linejoin="round" />
                        </svg>
                    </a><span id="chat-dot" class="badge rounded-pill badge-tertiary">
                        {{ $totalUnread > 99 ? '99+' : $totalUnread }}
                    </span>
                </li>
                <!-- thông tin  -->
                <li class="profile-dropdown custom-dropdown">
                    <div class="d-flex align-items-center"><img loading="lazy"
                            src="{{ asset('assets/images/profile.png') }}" alt="">
                        <div class="flex-grow-1">
                            <h5>

                                @if (auth()->check())
                                    {{ auth()->user()->role }}
                                    <sup style="font-size: 0.7em; color: red;">{{ auth()->user()->id }}</sup>
                                @else
                                    <span class="text-muted">Guest</span>
                                @endif



                            </h5>
                            @if (auth()->check())
                                <span>{{ auth()->user()->email }}</span>
                            @else
                                <span class="text-muted">Chưa đăng nhập</span>
                            @endif

                        </div>

                    </div>
                    <div class="custom-menu overflow-hidden">
                        <ul class="list-unstyled m-0 p-0">
                            <!-- Account -->
                            <li>
                                <a href="#"
                                    class="d-flex align-items-center px-3 py-2 text-decoration-none text-dark rounded menu-link">
                                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" />
                                        <path d="M5.5 21h13a8.38 8.38 0 00-13 0z" stroke="currentColor" stroke-width="2"
                                            stroke-linejoin="round" />
                                    </svg>
                                    <span>Account</span>
                                </a>
                            </li>

                            <!-- Inbox -->
                            <li>
                                <a href="#"
                                    class="d-flex align-items-center px-3 py-2 text-decoration-none text-dark rounded menu-link">
                                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h12a2 2 0 012 2z"
                                            stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                    </svg>
                                    <span>Inbox</span>
                                </a>
                            </li>

                            <!-- Task -->
                            <li>
                                <a href="#"
                                    class="d-flex align-items-center px-3 py-2 text-decoration-none text-dark rounded menu-link">
                                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"
                                            stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                        <path d="M14 2v6h6" stroke="currentColor" stroke-width="2" />
                                    </svg>
                                    <span>Task</span>
                                </a>
                            </li>

                            <!-- Log Out -->
                            <li>
                                <a href="{{ route('logout') }}"
                                    class="d-flex align-items-center px-3 py-2 text-decoration-none text-dark rounded menu-link">
                                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4" stroke="currentColor"
                                            stroke-width="2" stroke-linejoin="round" />
                                        <path d="M10 17l5-5-5-5" stroke="currentColor" stroke-width="2"
                                            stroke-linejoin="round" stroke-linecap="round" />
                                        <path d="M15 12H3" stroke="currentColor" stroke-width="2"
                                            stroke-linejoin="round" stroke-linecap="round" />
                                    </svg>
                                    <span>Log Out</span>
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
        const darkModeBtn = document.querySelector('.dark-mode');

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

        // Auto load theme nếu đã lưu
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatDot = document.getElementById('chat-dot');
        const authId = {{ auth()->id() }};

        if (window.Echo && authId) {
            window.Echo.private('user.' + authId)
                .listen('MessageNotification', (e) => {
                    const unread = e.unread_total;

                    if (chatDot) {
                        if (unread > 0) {
                            chatDot.innerText = unread > 99 ? '99+' : unread;
                            chatDot.style.display = 'flex';
                        } else {
                            chatDot.style.display = 'none';
                        }
                    } else {
                        // Nếu chưa có sẵn badge, thì tạo mới
                        const aTag = document.getElementById('chatDropdown');
                        if (aTag) {
                            const badge = document.createElement('span');
                            badge.id = 'chat-dot';
                            badge.className =
                                'position-absolute top-0 start-100 translate-middle bg-danger text-white d-flex justify-content-center align-items-center rounded-circle shadow';
                            badge.style =
                                'font-size: 10px; min-width: 18px; height: 18px; padding: 0 4px; border: 2px solid #fff;';
                            badge.innerText = unread > 99 ? '99+' : unread;
                            aTag.appendChild(badge);
                        }
                    }
                });
        }
    });
</script>

<script>
    if (typeof window.Echo !== 'undefined') {
        console.log('Echo loaded, lắng nghe thông báo toàn cục...');

        window.Echo.channel('global-notification')
            .listen('.global.notification', function (data) {
                console.log('Đã nhận sự kiện toàn cục:', data);
                showGlobalNotification(data.message, data.link);
            });
    } else {
        console.error('Echo chưa được khởi tạo hoặc chưa kết nối Pusher!');
    }

    function showGlobalNotification(message, link) {
        // Loại bỏ toast cũ (nếu có)
        $('#global-toast').remove();

        // Tạo popup/toast
        let html = `<div id="global-toast" style="
            position:fixed;top:24px;right:24px;z-index:99999;
            background:#232323;color:#fff;padding:16px 32px;
            border-radius:8px;font-size:1.1rem;box-shadow:0 2px 12px #0006;
            display:flex;align-items:center;
        ">
            <span>${message}</span>
            ${link ? `<a href="${link}" style="color:#ffd700;text-decoration:underline;margin-left:12px;">Xem</a>` : ''}
            <span style="cursor:pointer;float:right;font-weight:bold;margin-left:16px;" onclick="$('#global-toast').fadeOut()">×</span>
        </div>`;
        $('body').append(html);
        setTimeout(() => {
            $('#global-toast').fadeOut();
        }, 10000);
    }
</script>
{{-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
<script>
    window.Pusher = Pusher;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '1ea633f39dfb08c3c0c2',
        cluster: 'ap1',
        forceTLS: true,
    });
    console.log('ffff', window.Echo);

    const userId = {{ auth()->id() }};

    if (userId && window.Echo) {
        window.Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                console.log('Received new notification via Pusher:', notification);

                const notiCount = document.getElementById('noti-count');
                if (notiCount) {
                    let count = parseInt(notiCount.textContent) || 0;
                    notiCount.textContent = count + 1; // tăng số badge lên 1
                    notiCount.style.display = 'inline-block';
                }
            });

    } else {
        console.warn('User is not logged in or Echo is not initialized.');
    }
</script> --}}