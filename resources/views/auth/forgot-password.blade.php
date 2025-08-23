<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - Website Tuyển Dụng IT HireNow</title>
    <link rel="icon" href="{{ asset('../assets/images/favicon/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css') }}">
    <link href="{{ url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap') }}"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('../assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('../assets/css/color-1.css') }}">
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
                        <div class="login-main">
                            <form class="theme-form" method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <h2 class="text-center">Quên mật khẩu</h2>
                                <p class="text-center">Nhập địa chỉ email để nhận liên kết đặt lại mật khẩu</p>

                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label class="col-form-label">Địa chỉ Email</label>
                                    <input class="form-control" type="email" name="email"
                                        placeholder="Nhập email của bạn" required autofocus>
                                </div>

                                <div class="form-group mb-0">
                                    <button class="btn btn-primary btn-block w-100 mt-3" type="submit">
                                        Gửi liên kết đặt lại mật khẩu
                                    </button>
                                </div>

                                <p class="mt-4 mb-0 text-center">
                                    <a class="ms-2" href="{{ route('showLoginForm') }}">
                                        Quay lại trang đăng nhập
                                    </a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JS -->
        <script src="{{ asset('../assets/js/vendors/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('../assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('../assets/js/config.js') }}"></script>
        <script src="{{ asset('../assets/js/script.js') }}"></script>
    </div>
</body>

</html>
