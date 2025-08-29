<!DOCTYPE html>
<html lang="vi">
<head>
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
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div>
                        <div style="align-items: center; display: flex; justify-content: center; height: 100px;">
                            <a href="{{ route('home') }}">
                                @php
                                $clientLogo = \App\Models\Logo::where('type', 'client')
                                ->where('is_active', true)
                                ->first();
                                @endphp
                                <img src="{{ $clientLogo ? asset('storage/' . $clientLogo->image_path) : asset('images/default.png') }}"
                                    alt="Client Logo" style="height: 120px;">
                            </a>
                        </div>
                        <div class="login-main mt-2">
                            <form class="theme-form" method="POST" action="{{ route('registerEmployer') }}">
                                @csrf
                                <h2 class="text-center mb-2">Tạo tài khoản Employer</h2>

                                @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <div class="row">
                                    <!-- Cột trái: Thông tin liên lạc -->
                                    <div class="col-md-6">
                                        <h4 class="mb-3">Thông tin liên lạc</h4>
                                        <div class="form-group mb-2">
                                            <label>Họ và Tên <span class="text-danger">*</span></label>
                                            <input class="form-control @error('full_name') is-invalid @enderror"
                                                type="text" name="full_name" value="{{ old('full_name') }}"
                                                placeholder="Họ và tên">
                                            @error('full_name') <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-2">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input class="form-control @error('email') is-invalid @enderror"
                                                type="email" name="email" value="{{ old('email') }}"
                                                placeholder="Email">
                                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="form-group mb-2">
                                            <label>Số điện thoại <span class="text-danger">*</span></label>
                                            <input class="form-control @error('phone') is-invalid @enderror" type="tel"
                                                name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại">
                                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <h4 class="mb-3">Thông tin công ty</h4>

                                        <div class="form-group mb-2">
                                            <label>Tên công ty <span class="text-danger">*</span></label>
                                            <input class="form-control @error('company_name') is-invalid @enderror"
                                                type="text" name="company_name" value="{{ old('company_name') }}"
                                                placeholder="Tên công ty">
                                            @error('company_name') <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-2">
                                            <label>Thành phố <span class="text-danger">*</span></label>
                                            <select class="form-control @error('city_id') is-invalid @enderror"
                                                name="city_id">
                                                <option value="">-- Chọn Thành phố công ty --</option>
                                                @foreach($locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('city_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="form-group mb-2">
                                            <label>Địa chỉ</label>
                                            <input class="form-control @error('address') is-invalid @enderror"
                                                type="text" name="address" value="{{ old('address') }}"
                                                placeholder="Địa chỉ công ty">
                                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Mật khẩu -->
                                <h4 class="mt-2 mb-2">Bảo mật</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="col-form-label mb-2">Mật khẩu</label>
                                            <div class="form-input position-relative">
                                                <input class="form-control" type="password" id="password" name="password"
                                                    placeholder="*********">
                                                <div class="show-hide"><span class="show"></span></div>
                                                @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="col-form-label mb-2">Nhập lại mật khẩu</label>
                                            <div class="form-input position-relative">
                                                <input class="form-control" type="password" id="password_confirmation"
                                                    name="password_confirmation" placeholder="*********">
                                                <div class="show-hide"><span class="show"></span></div>
                                                @error('password_confirmation')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Điều khoản -->
                                <div class="form-check checkbox-solid-info mt-2">
                                    <input class="form-check-input" id="solid6"
                                        type="checkbox" name="terms">
                                    <label class="form-check-label" for="solid6">
                                        Tôi đã đọc và đồng ý với HireNow
                                        <a href="#">Điều khoản & Điều kiện</a> và
                                        <a href="#">Chính sách bảo mật</a>
                                    </label>
                                    @error('terms') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <button class="btn btn-primary btn-block w-100 mt-2" type="submit">
                                    Tạo tài khoản
                                </button>

                                <p class="mt-2 mb-0 text-center">
                                    Bạn đã có tài khoản?
                                    <a href="{{ route('showLoginForm') }}">Đăng nhập</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('../assets/js/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('../assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('../assets/js/config.js') }}"></script>
    <script src="{{ asset('../assets/js/password.js') }}"></script>
    <script src="{{ asset('../assets/js/script.js') }}"></script>
</body>

</html>