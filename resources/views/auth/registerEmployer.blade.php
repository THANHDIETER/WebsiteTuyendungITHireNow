<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Edmin admin is super flexible, powerful, clean & modern responsive bootstrap admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Edmin admin template, best javascript admin, dashboard template, bootstrap admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <title>Website Tuyển Dụng IT HireNow</title>
    <!-- Favicon icon-->
    <link rel="icon" href="{{ asset('../assets/images/favicon/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('../assets/images/favicon/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet"
        href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css') }}">
    <!-- Google font-->
    <link rel="preconnect" href="{{ url('https://fonts.googleapis.com/') }}">
    <link rel="preconnect" href="{{ url('https://fonts.gstatic.com/') }}" crossorigin="">
    <link
        href="{{ url('https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap') }}"
        rel="stylesheet">
    <!-- Font awesome icon css -->
    <link rel="stylesheet" href="{{ asset('../assets/css/vendors/%40fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('../assets/css/vendors/%40fortawesome/fontawesome-free/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('../assets/css/vendors/%40fortawesome/fontawesome-free/css/brands.css') }}">
    <link rel="stylesheet" href="{{ asset('../assets/css/vendors/%40fortawesome/fontawesome-free/css/solid.css') }}">
    <link rel="stylesheet" href="{{ asset('../assets/css/vendors/%40fortawesome/fontawesome-free/css/regular.css') }}">
    <!-- Ico Icon css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('../assets/css/vendors/%40icon/icofont/icofont.css') }}">
    <!-- Flag Icon css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <!-- Themify Icon css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('../assets/css/vendors/themify-icons/themify-icons/css/themify.css') }}">
    <!-- Animation css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('../assets/css/vendors/animate.css/animate.css') }}">
    <!-- Whether Icon css-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('../assets/css/vendors/weather-icons/css/weather-icons.min.css') }}">
    <!-- App css-->
    <link rel="stylesheet" href="{{ asset('../assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('../assets/css/color-1.css') }}" media="screen">
</head>

<body>
    <!-- tap to top-->
    <div class="tap-top">
        <svg class="feather">
            <use
                href="{{ url('https://admin.pixelstrap.net/edmin/assets/svg/feather-icons/dist/feather-sprite.svg#arrow-up') }}">
            </use>
        </svg>
    </div>
    <!-- register page start-->
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div>
                        <div><a class="logo text-center" href="index.html"><img class="img-fluid for-light"
                                    src="{{ asset('../assets/images/logo/logo.png') }}" alt="registerpage"><img
                                    class="img-fluid for-dark m-auto"
                                    src="{{ asset('../assets/images/logo/dark-logo.png') }}" alt="logo"></a></div>
                        <div class="login-main">
                            <form class="theme-form" method="POST" action="{{ route('registerEmployer') }}">
                                @csrf
                                <h2 class="text-center">Create Employer Account</h2>
                                <p class="text-center">Enter your personal details to create account</p>
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <!-- Thông tin liên lạc của bạn -->
                                <h4 class="mt-4">Your contact information</h4>
                                <div class="form-group">
                                    <label class="col-form-label">Full name <span class="text-danger">*</span></label>
                                    <input class="form-control @error('full_name') is-invalid @enderror" type="text"
                                        name="full_name" value="{{ old('full_name') }}" placeholder="Full name">
                                    @error('full_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Work Title <span class="text-danger">*</span></label>
                                    <input class="form-control @error('work_title') is-invalid @enderror" type="text"
                                        name="work_title" value="{{ old('work_title') }}" placeholder="Work Title">
                                    @error('work_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Work Email <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        name="email" value="{{ old('email') }}" placeholder="Work Email">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Phone Number <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control @error('phone') is-invalid @enderror" type="tel"
                                        name="phone" value="{{ old('phone') }}" placeholder="Phone Number">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">How did you know HireNow?</label>
                                    <select class="form-control @error('itvie_experience') is-invalid @enderror"
                                        name="itvie_experience">
                                        <option value="" disabled
                                            {{ old('itvie_experience') === null ? 'selected' : '' }}>-- How did you
                                            know HireNow? --
                                        </option>
                                        <option value="google"
                                            {{ old('itvie_experience') === 'google' ? 'selected' : '' }}>Google
                                        </option>
                                        <option value="facebook"
                                            {{ old('itvie_experience') === 'facebook' ? 'selected' : '' }}>Facebook
                                        </option>
                                        <option value="khac"
                                            {{ old('itvie_experience') === 'khac' ? 'selected' : '' }}>Khác
                                        </option>
                                    </select>
                                    @error('itvie_experience')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Thông tin công ty -->
                                <h4 class="mt-4">Company information</h4>
                                <div class="form-group">
                                    <label class="col-form-label">Company Name <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control @error('company_name') is-invalid @enderror"
                                        type="text" name="company_name" value="{{ old('company_name') }}"
                                        placeholder="Company Name">
                                    @error('company_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Company Location <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('company_location') is-invalid @enderror"
                                        name="company_location">
                                        <option value="" disabled
                                            {{ old('company_location') === null ? 'selected' : '' }}>-- Company
                                            Location
                                            --</option>
                                        <option value="hanoi"
                                            {{ old('company_location') === 'hanoi' ? 'selected' : '' }}>Hà Nội</option>
                                        <option value="hcm"
                                            {{ old('company_location') === 'hcm' ? 'selected' : '' }}>TP. Hồ Chí Minh
                                        </option>
                                        <option value="danang"
                                            {{ old('company_location') === 'danang' ? 'selected' : '' }}>Đà Nẵng
                                        </option>
                                        <option value="khac"
                                            {{ old('company_location') === 'khac' ? 'selected' : '' }}>Khác
                                        </option>
                                    </select>
                                    @error('company_location')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Website Url</label>
                                    <input class="form-control @error('website_url') is-invalid @enderror"
                                        type="url" name="website_url" value="{{ old('website_url') }}"
                                        placeholder="Website Url">
                                    @error('website_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-0 checkbox-checked">
                                    <div class="form-group">
                                        <label class="col-form-label">Password <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control @error('password') is-invalid @enderror"
                                            type="password" name="password" placeholder="Password">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Confirm Password <span
                                                class="text-danger">*</span></label>
                                        <input
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            type="password" name="password_confirmation"
                                            placeholder="Confirm Password">
                                        @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-check checkbox-solid-info">
                                        <input class="form-check-input @error('terms') is-invalid @enderror"
                                            id="solid6" type="checkbox" name="terms">
                                        <label class="form-check-label" for="solid6">I have read and agree to
                                            HireNow<a href="#">Terms & Conditions</a> and <a
                                                href="#">Privacy Policy</a>in relation to my privacy
                                            information.</label>
                                        @error('terms')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button class="btn btn-primary btn-block w-100 mt-3" type="submit">Create
                                        Account</button>
                                </div>
                                <p
                                    class="mt-4 mb-0 text-center d-flex align-items-center justify-content-center gap-2">
                                    Already have an account?
                                    <a href="{{ route('showLoginForm') }}" class="ms-2">Sign in</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- jquery-->
        <script src="{{ asset('../assets/js/vendors/jquery/dist/jquery.min.js') }}"></script>
        <!-- bootstrap js-->
        <script src="{{ asset('../assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('../assets/js/config.js') }}"></script>
        <!-- scrollbar js-->
        <!-- scrollable-->
        <script src="{{ asset('../assets/js/password.js') }}"></script>
        <!-- customizer-->
        <!-- custom script -->
        <script src="{{ asset('../assets/js/script.js') }}"></script>
    </div>
</body>

</html>
