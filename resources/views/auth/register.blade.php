<!DOCTYPE html>
<html lang="vi">
<head>
    <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../assets/css/style.css') }}">
    @include('website.layouts.particals.css')

    <style>
        body {
            background: linear-gradient(135deg, #1CB5E0, #000851);
        }

        .login-card {
            background: #ffffffee;
        }
    </style>
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
    <!-- login page start-->
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div>
                        <div style="align-items: center;
                                display: flex;
                                justify-content: center;
                                height: 100px;">
                            <a href="{{ route('home') }}">
                                @php
                                $clientLogo = \App\Models\Logo::where('type', 'client')
                                ->where('is_active', true)
                                ->first();
                                @endphp

                                <img src="{{ $clientLogo ? asset('storage/' . $clientLogo->image_path) : asset('images/default.png') }}"
                                    alt="Client Logo" style="height: 120px; " {{-- hoặc dùng class --}}>
                            </a>
                        </div>
                        <div class="login-main mt-2">
                            <form class="theme-form" method="POST" action="{{ route('register.post') }}">
                                @csrf
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
                                <h2 class="text-center">Tạo tài khoản</h2>
                                <div class="form-group">
                                    <label class="col-form-label">Email</label>
                                    <input class="form-control" type="email" name="email" placeholder="Địa chỉ Email">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Mật khẩu</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" id="password" name="password"
                                            placeholder="*********">
                                        <div class="show-hide"><span class="show"></span></div>
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Nhập lại mật khẩu</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" id="password_confirmation"
                                            name="password_confirmation" placeholder="*********">
                                        <div class="show-hide"><span class="show"></span></div>
                                        @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-0 checkbox-checked">
                                    
                                    <button class="btn btn-primary btn-block w-100 mt-2" type="submit">
                                        TẠO TÀI KHOẢN </button>
                                </div>
                                <div class="login-social-title">
                                    <h6>đăng ký khác </h6>
                                </div>
                                <div class="form-group">
                                    <ul class="login-social">
                                        <li><a href="{{ route('auth.redirect') }}"><i
                                                    class="fa-brands fa-google"></i></a></li>
                                    </ul>
                                </div>
                                <div id="googleButton" class="g-signin2" data-onsuccess="onSignIn" data-theme="dark">
                                </div>
                                <p
                                    class="ms-5 mb-0 text-center d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('showLoginForm') }}" class="ms-2">Đăng nhập</a>
                                    <span>|</span>
                                    <a href="{{ route('registerEmployer') }}">Tạo tài khoản Employer
                                    </a>
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