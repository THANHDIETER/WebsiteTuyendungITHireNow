@php
    use App\Models\Logo;
    $logo = Logo::where('type', 'site')->where('is_active', 1)->first();
@endphp
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thông báo hệ thống</title>
</head>

<body style="margin:0; padding:20px; background-color:#eef1f7; font-family: Arial, Helvetica, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg, #007bff, #0056d6); padding:25px; text-align:center;">
                            @if($logo && $logo->image_path)
                                <img src="{{ asset('storage/'.$logo->image_path) }}" alt="Company Logo"
                                    style="max-width:160px; display:block; margin:0 auto 15px auto;">
                            @else
                                <h1 style="margin:0; font-size:26px; color:#fff; font-weight:bold;">IT HireNow</h1>
                            @endif

                            <h2 style="margin:0; font-size:22px; color:#fff; font-weight:bold;">
                                📨 Thông báo hệ thống
                            </h2>
                        </td>
                    </tr>

                    <!-- Nội dung -->
                    <tr>
                        <td style="padding:30px; font-size:15px; color:#333; line-height:1.7;">
                            <p style="margin:0 0 20px; font-size:16px;">
                                {{ $messageText }}
                            </p>

                            @if($link)
                                <div style="text-align:center; margin:30px 0;">
                                    <a href="{{ url($link) }}" 
                                       style="background:#28a745; color:#fff; padding:14px 28px; 
                                              text-decoration:none; border-radius:8px; 
                                              font-size:16px; font-weight:bold; display:inline-block;">
                                        👉 Xem chi tiết
                                    </a>
                                </div>
                            @endif
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9fafc; padding:20px; text-align:center; font-size:13px; color:#666; line-height:1.5;">
                            © {{ date('Y') }} <strong>Công ty IT HireNow</strong>. <br>
                            Mọi quyền được bảo lưu.  
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
