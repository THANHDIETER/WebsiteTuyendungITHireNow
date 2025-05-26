<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài liệu nội bộ</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; }
        h1 { color: #333; }
        h2 { color: #555; margin-top: 20px; }
        pre { background: #f4f4f4; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Tài liệu nội bộ</h1>
    <p>Chào mừng đến với tài liệu nội bộ của dự án. Tài liệu này cung cấp thông tin chi tiết về cách cài đặt, cấu trúc dự án, API và hướng dẫn sử dụng.</p>

    <h2>1. Giới thiệu</h2>
    <p>Dự án này là một ứng dụng web được xây dựng bằng Laravel, cung cấp các chức năng quản lý người dùng, bài đăng tuyển dụng và hồ sơ (CV).</p>

    <h2>2. Cài đặt</h2>
    <p>Để cài đặt dự án, hãy làm theo các bước sau:</p>
    <pre>
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
    </pre>

    <h2>3. Cấu trúc dự án</h2>
    <p>Dự án có cấu trúc thư mục như sau:</p>
    <pre>
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   ├── Employer/
│   │   ├── JobSeeker/
│   │   └── Auth/
│   ├── Middleware/
│   └── Requests/
├── Models/
└── Providers/
resources/
├── views/
│   ├── admin/
│   ├── employer/
│   ├── jobseeker/
│   ├── auth/
│   └── layouts/
routes/
├── web.php
├── admin.php
├── employer.php
└── jobseeker.php
    </pre>

    <h2>4. API</h2>
    <p>Dự án cung cấp các API sau:</p>
    <pre>
GET /api/users - Lấy danh sách người dùng
POST /api/users - Tạo người dùng mới
GET /api/jobs - Lấy danh sách bài đăng tuyển dụng
POST /api/jobs - Tạo bài đăng tuyển dụng mới
GET /api/resumes - Lấy danh sách hồ sơ (CV)
POST /api/resumes - Tạo hồ sơ (CV) mới
    </pre>

    <h2>5. Hướng dẫn sử dụng</h2>
    <p>Để sử dụng dự án, hãy làm theo các bước sau:</p>
    <ol>
        <li>Đăng nhập vào hệ thống bằng tài khoản của bạn.</li>
        <li>Nếu bạn là Admin, bạn có thể quản lý người dùng tại đường dẫn <code>/admin/users</code>.</li>
        <li>Nếu bạn là Employer, bạn có thể quản lý bài đăng tuyển dụng tại đường dẫn <code>/employer/jobs</code>.</li>
        <li>Nếu bạn là Job Seeker, bạn có thể quản lý hồ sơ (CV) tại đường dẫn <code>/jobseeker/resumes</code>.</li>
    </ol>
</body>
</html>
