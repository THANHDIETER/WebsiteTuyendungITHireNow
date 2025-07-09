<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
    content="Edmin admin is super flexible, powerful, clean &amp; modern responsive bootstrap admin template with unlimited possibilities.">
<meta name="keywords"
    content="admin template, Edmin admin template, best javascript admin, dashboard template, bootstrap admin template, responsive admin template, web app">
<meta name="author" content="pixelstrap">

<title>{{ $title ?? 'Admin' }}</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle (kèm Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome 6 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- Favicon icon-->
<link rel="icon" href="{{ asset('client/assets/img/logo-ithirenow-glow.png') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('client/assets/img/logo-ithirenow-glow.png') }}" type="image/x-icon">
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
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/css/vendors/weather-icons/css/weather-icons.min.css') }}">
<!-- Apex Chart css-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/apexcharts.css') }}">
<!-- Data Table css-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/simple-datatables/dist/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}">
<!-- App css-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
<meta property="og:url" content="{{ url()->current() }}">
@if (session('access_token'))
    <script>
        localStorage.setItem('access_token', "{{ session('access_token') }}");
    </script>
@endif
<header class="page-header row">
    <div class="logo-wrapper d-flex align-items-center col-auto"><a href=""><img class="for-light"
                src="{{ asset('client/assets/img/logo-ithirenow-glow.png') }}" style="width: 100px" loading="lazy"
                alt="logo"><img class="for-dark" src="{{ asset('client/assets/img/logo-ithirenow-glow.png') }}"
                style="width: " loading="lazy" alt="logo"></a><a class="close-btn" href="javascript:void(0)">
            <div class="toggle-sidebar">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </a></div>
    <div class="page-main-header col">
        <div class="header-left d-lg-block d-none">
            <form class="search-form mb-0">
                <div class="input-group"><span class="input-group-text pe-0">
                        <!-- Icon Search -->
                        <svg class="search-bg svg-color" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <input class="form-control" type="text" placeholder="Search anything...">
                </div>
            </form>
        </div>
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
                            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <div class="form-group search-form">
                        <input type="text" placeholder="Search here...">
                    </div>
                </li>
                <!-- Notification menu -->
                <li class="custom-dropdown">
                    <a href="javascript:void(0)" id="notification-toggle">
                        <!-- Icon Bell -->
                        <svg class="svg-color circle-color" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M13.73 21a2 2 0 01-3.46 0" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <span class="badge rounded-pill badge-secondary" id="noti-count">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>

                    <div class="custom-menu notification-dropdown py-0 overflow-hidden">
                        <h5 class="title bg-primary-light">
                            Notifications
                            <a href="{{ route('admin.notifications.index') }}">
                                <span class="font-primary">View</span>
                            </a>
                        </h5>
                        <ul class="activity-update" id="noti-list">


                            @forelse(auth()->user()->unreadNotifications->take(5) as $noti)
                                <li class="d-flex align-items-center b-l-primary">
                                    <div class="flex-grow-1">
                                        <span>{{ $noti->created_at->diffForHumans() }}</span>
                                        <a href="{{ $noti->data['link_url'] }}">
                                            <h5>{{ $noti->data['message'] }}</h5>
                                        </a>
                                        <h6>{{ config('app.name') }}</h6>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <img class="b-r-15 img-40"
                                            src="{{ asset('assets/images/avatar/default.jpg') }}" alt="">
                                    </div>
                                </li>
                            @empty
                                <li class="d-flex justify-content-center p-2 text-muted">
                                    Không có thông báo mới
                                </li>
                            @endforelse

                            <li class="mt-3 d-flex justify-content-center">
                                <div class="button-group">
                                    <a class="btn btn-secondary" href="{{ route('admin.notifications.index') }}">All
                                        Notification</a>
                                </div>
                            </li>
                            <script>
                                setInterval(() => {
                                    fetch('{{ route('admin.notifications.latest') }}')
                                        .then(res => res.json())
                                        .then(notis => {
                                            const list = document.getElementById('noti-list');

                                            notis.forEach(noti => {
                                                if (!list.querySelector(`[data-id="${noti.id}"]`)) {
                                                    const item = `
                            <li class="d-flex align-items-center b-l-primary" data-id="${noti.id}">
                                <div class="flex-grow-1">
                                    <span>${noti.time}</span>
                                    <a href="${noti.link_url}">
                                        <h5>${noti.message}</h5>
                                    </a>
                                    <h6>{{ config('app.name') }}</h6>
                                </div>
                                <div class="flex-shrink-0">
                                    <img class="b-r-15 img-40" src="/assets/images/avatar/default.jpg" alt="">
                                </div>
                            </li>
                        `;
                                                    list.insertAdjacentHTML('afterbegin', item);
                                                }
                                            });

                                            // Cập nhật badge
                                            const badge = document.getElementById('noti-count');
                                            if (badge) {
                                                badge.innerText = notis.length;
                                                badge.classList.toggle('d-none', notis.length === 0);
                                            }
                                        });
                                }, 5000);
                            </script>

                        </ul>
                    </div>
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
                                        <input class="form-control" type="text"
                                            placeholder="Search Bookmark..."><span class="input-group-text">
                                            <!-- Icon Search -->
                                            <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="11" cy="11" r="7" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </div>
                                </form>
                            </li>
                            <li class="d-flex align-items-center bg-light-primary">
                                <div class="flex-shrink-0 me-2"><a href="">
                                        <!-- Icon Home -->
                                        <svg class="svg-color stroke-primary" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 12l9-9 9 9v9a3 3 0 01-3 3H6a3 3 0 01-3-3v-9z"
                                                stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                            <path d="M9 21V12h6v9" stroke="currentColor" stroke-width="2"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a></div>
                                <div class="d-flex justify-content-between align-items-center w-100"><a
                                        href="">Dashboard</a>
                                    <svg class="svg-color icon-star" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                            <circle cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="2" />
                                            <path d="M12 2v10h10" stroke="currentColor" stroke-width="2"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a></div>
                                <div class="d-flex justify-content-between align-items-center w-100"><a
                                        href="">To-do</a>
                                    <svg class="svg-color icon-star" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                    <svg class="svg-color icon-star" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                                <line x1="5" y1="12" x2="19" y2="12"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                        <input class="form-control input-touchspin bg-light-primary" type="number"
                                            value="5">
                                        <button class="increment-touchspin btn-touchspin">
                                            <!-- Icon Plus -->
                                            <svg class="svg-color" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <line x1="12" y1="5" x2="12" y2="19"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                <line x1="5" y1="12" x2="19" y2="12"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
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
                                                <line x1="5" y1="12" x2="19" y2="12"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                        <input class="form-control input-touchspin bg-light-secondary" type="number"
                                            value="5">
                                        <button class="increment-touchspin btn-touchspin">
                                            <!-- Icon Plus -->
                                            <svg class="svg-color" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <line x1="12" y1="5" x2="12" y2="19"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                <line x1="5" y1="12" x2="19" y2="12"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
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
                                                <line x1="5" y1="12" x2="19" y2="12"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                        <input class="form-control input-touchspin bg-light-tertiary" type="number"
                                            value="5">
                                        <button class="increment-touchspin btn-touchspin">
                                            <!-- Icon Plus -->
                                            <svg class="svg-color" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <line x1="12" y1="5" x2="12" y2="19"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                <line x1="5" y1="12" x2="19" y2="12"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
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
                <!-- Bookmark menu-->
                <li class="custom-dropdown"><a href="javascript:void(0)">
                        <!-- Icon Message -->
                        <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h12a2 2 0 012 2z" stroke="currentColor"
                                stroke-width="2" stroke-linejoin="round" />
                        </svg>
                    </a><span class="badge rounded-pill badge-tertiary">3</span>
                    <div class="custom-menu message-dropdown py-0 overflow-hidden">
                        <h5 class="title bg-primary-light">Messages</h5>
                        <ul>
                            <li class="d-flex b-t-primary">
                                <div class="d-block"><a href="">
                                        <h5>Design meeting</h5>
                                    </a>
                                    <h6>
                                        <svg class="feather me-1" width="16" height="16" viewBox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="2" />
                                            <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg><span>Just Now</span>
                                    </h6>
                                </div>
                                <div class="badge badge-light-danger">
                                    <svg class="feather me-1" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="2" />
                                        <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg><span>Open</span>
                                </div>
                            </li>
                            <li class="d-flex b-t-secondary">
                                <div class="d-block"><a href="">
                                        <h5>Weekly scurm Meeting</h5>
                                    </a>
                                    <h6>
                                        <svg class="feather me-1" width="16" height="16" viewBox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="2" />
                                            <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg><span>1 Hour Ago</span>
                                    </h6>
                                </div>
                                <div class="badge badge-light-danger">
                                    <svg class="feather me-1" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="2" />
                                        <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg><span>Open</span>
                                </div>
                            </li>
                            <li class="d-flex b-t-tertiary">
                                <div class="d-block"><a href="">
                                        <h5>Check your login page</h5>
                                    </a>
                                    <h6>
                                        <svg class="feather me-1" width="16" height="16" viewBox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="2" />
                                            <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg><span>2 Hour Ago</span>
                                    </h6>
                                </div>
                                <div class="badge badge-light-success">
                                    <svg class="feather me-1" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="2" />
                                        <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg><span>Closed</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
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
                        <ul>
                            <li class="d-flex">
                                <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 6V5a4 4 0 0 1 8 0v1" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <rect x="4" y="6" width="16" height="14" rx="2"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M8 12H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg><a class="ms-2" href="{{ route('employer.dashboard') }}">Employer</a>
                            </li>
                            <li class="d-flex">
                                <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 9.5L12 3L21 9.5V20A1.5 1.5 0 0 1 19.5 21H4.5A1.5 1.5 0 0 1 3 20V9.5Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M9 21V12H15V21" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg><a class="ms-2" href="{{ route('home') }}">Client</a>
                            </li>
                            <li class="d-flex">
                                <!-- Icon Profile -->
                                <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="7" r="4" stroke="currentColor"
                                        stroke-width="2" />
                                    <path d="M5.5 21h13a8.38 8.38 0 00-13 0z" stroke="currentColor" stroke-width="2"
                                        stroke-linejoin="round" />
                                </svg><a class="ms-2" href="">Account</a>
                            </li>
                            <li class="d-flex">
                                <!-- Icon Message -->
                                <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h12a2 2 0 012 2z"
                                        stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                </svg><a class="ms-2" href="">Inbox</a>
                            </li>
                            <li class="d-flex">
                                <!-- Icon Document -->
                                <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"
                                        stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                    <path d="M14 2v6h6" stroke="currentColor" stroke-width="2"
                                        stroke-linejoin="round" />
                                </svg><a class="ms-2" href="">Task</a>
                            </li>
                            <li class="d-flex">
                                <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4" stroke="currentColor"
                                        stroke-width="2" stroke-linejoin="round" />
                                    <path d="M10 17l5-5-5-5" stroke="currentColor" stroke-width="2"
                                        stroke-linejoin="round" stroke-linecap="round" />
                                    <path d="M15 12H3" stroke="currentColor" stroke-width="2" stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                                <a class="ms-2" href="{{ route('logout') }}">Log Out</a>
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
