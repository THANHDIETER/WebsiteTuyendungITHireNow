<header class="header-area transparent">
    
    <div class="container">
        
        <div class="row no-gutter align-items-center position-relative">
            <div class="col-12">
                <div class="header-align">
                    <div class="header-align-start">
                        <div class="header-logo-area">
                            <a href="index.html">
                                <img class="logo-main" src="{{ asset('client/assets/img/logo-light.webp') }}" alt="Logo" />
                                <img class="logo-light" src="{{ asset('client/assets/img/logo-light.webp')}}" alt="Logo" />
                            </a>
                        </div>
                    </div>
                    
                    <div class="header-align-center">
                        <div class="header-navigation-area position-relative">
                            <ul class="main-menu nav">
                                <li><a href="index.html"><span>Home</span></a></li>
                                <li class="has-submenu"><a href="index.html#/"><span>Find Jobs</span></a>
                                    <ul class="submenu-nav">
                                        <li><a href="job.html"><span>Jobs</span></a></li>
                                        <li><a href="job-details.html"><span>Job Details</span></a></li>
                                    </ul>
                                </li>
                                <li><a href="employers-details.html"><span>Employers Details</span></a></li>
                                <li class="has-submenu"><a href="index.html#/"><span>Candidates</span></a>
                                    <ul class="submenu-nav">
                                        <li><a href="candidate.html"><span>Candidates</span></a></li>
                                        <li><a href="candidate-details.html"><span>Candidate Details</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-submenu"><a href="index.html#/"><span>Blog</span></a>
                                    <ul class="submenu-nav">
                                        <li><a href="blog-grid.html">Blog Grid</a></li>
                                        <li><a href="blog.html">Blog Left Sidebar</a></li>
                                        <li><a href="blog-right-sidebar.html">Blog Right Sidebar</a></li>
                                        <li><a href="blog-details.html">Blog Details</a></li>
                                    </ul>
                                </li>
                                <li class="has-submenu"><a href="index.html#/"><span>Pages</span></a>
                                    <ul class="submenu-nav">
                                        <li><a href="about-us.html"><span>About us</span></a></li>
                                        <li><a href="login.html"><span>Login</span></a></li>
                                        <li><a href="{{ route('register') }}"><span>Registration</span></a></li>
                                        <li><a href="page-not-found.html"><span>Page Not Found</span></a></li>
                                    </ul>
                                </li>
                                <li><a href="contact.html"><span>Contact</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="header-align-end">
                        <div class="header-action-area">
                            <a class="btn-registration" href="{{ route('register') }}"><span>+</span> Registration</a>
                            <button class="btn-menu" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#AsideOffcanvasMenu" aria-controls="AsideOffcanvasMenu">
                                <i class="icofont-navigation-menu"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</header>
<div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <div class="page-header-content">
                            <h2 class="title">Employers Details</h2>
                            <nav class="breadcrumb-area">
                                <ul class="breadcrumb justify-content-center">
                                    <li><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li>Employers</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
