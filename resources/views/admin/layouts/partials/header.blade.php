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
<link rel="icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">
<!-- Google font-->
<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
    rel="stylesheet">
<!-- App css -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta property="og:url" content="{{ url()->current() }}">

@if (session('access_token'))
    <script>
        localStorage.setItem('access_token', "{{ session('access_token') }}");
    </script>
@endif

<header class="page-header row">
    <div class="logo-wrapper d-flex align-items-center col-auto">
        <a href="">
            <img class="for-light" src="{{ asset('assets/images/logo/logo.png') }}" alt="logo">
            <img class="for-dark" src="{{ asset('assets/images/logo/dark-logo.png') }}" alt="logo">
        </a>
        <a class="close-btn" href="javascript:void(0)">
            <div class="toggle-sidebar">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </a>
    </div>
    <div class="page-main-header col">
        <div class="header-left d-lg-block d-none">
            <form class="search-form mb-0">
                <div class="input-group">
                    <span class="input-group-text pe-0">
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
            <ul class="header-right d-flex align-items-center">
                <li class="modes d-flex">
                    <a class="dark-mode">
                        <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>
                <li class="custom-dropdown">
                    <a href="javascript:void(0)">
                        <svg class="svg-color circle-color" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M13.73 21a2 2 0 01-3.46 0" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <span class="badge rounded-pill badge-secondary">3</span>
                    <div class="custom-menu notification-dropdown py-0 overflow-hidden">
                        <h5 class="title bg-primary-light">Notifications <a href=""><span
                                    class="font-primary">View</span></a></h5>
                        <ul class="activity-update">
                            <li class="d-flex align-items-center b-l-primary">
                                <div class="flex-grow-1">
                                    <span>Just Now</span>
                                    <a href="">
                                        <h5>What`s the project report update?</h5>
                                    </a>
                                    <h6>Rick Novak</h6>
                                </div>
                                <div class="flex-shrink-0">
                                    <img class="b-r-15 img-40" src="{{ asset('assets/images/avatar/10.jpg') }}"
                                        alt="">
                                </div>
                            </li>
                            <li class="d-flex align-items-center b-l-secondary">
                                <div class="flex-grow-1">
                                    <span>12:47 am</span>
                                    <a href="">
                                        <h5>James created changelog page</h5>
                                    </a>
                                    <h6>Susan Connor</h6>
                                </div>
                                <div class="flex-shrink-0">
                                    <img class="b-r-15 img-40" src="{{ asset('assets/images/avatar/4.jpg') }}"
                                        alt="">
                                </div>
                            </li>
                            <li class="d-flex align-items-center b-l-tertiary">
                                <div class="flex-grow-1">
                                    <span>06:10 pm</span>
                                    <a href="">
                                        <h5>Polly edited Contact page</h5>
                                    </a>
                                    <h6>Roger Lum</h6>
                                </div>
                                <div class="flex-shrink-0">
                                    <img class="b-r-15 img-40" src="{{ asset('assets/images/avatar/1.jpg') }}"
                                        alt="">
                                </div>
                            </li>
                            <li class="mt-3 d-flex justify-content-center">
                                <div class="button-group">
                                    <a class="btn btn-secondary" href="">All Notification</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="profile-dropdown custom-dropdown">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/profile.png') }}" alt="">
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
                                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="7" r="4" stroke="currentColor"
                                            stroke-width="2" />
                                        <path d="M5.5 21h13a8.38 8.38 0 00-13 0z" stroke="currentColor"
                                            stroke-width="2" stroke-linejoin="round" />
                                    </svg>
                                    <span>Account</span>
                                </a>
                            </li>

                            <!-- Inbox -->
                            <li>
                                <a href="#"
                                    class="d-flex align-items-center px-3 py-2 text-decoration-none text-dark rounded menu-link">
                                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
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

<style>
    .custom-menu a {
        text-decoration: none;
        color: inherit;
    }

    .custom-menu a:hover {
        color: #007bff;
        text-decoration: none;
    }

    .menu-link {
        color: #212529;
        transition: color 0.2s ease;
    }

    .menu-link:hover {
        color: #007bff;
        /* Màu chữ khi hover */
    }

    .menu-link:hover svg {
        stroke: #007bff;
        /* Màu icon khi hover */
    }
</style>
