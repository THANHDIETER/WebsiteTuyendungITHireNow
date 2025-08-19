<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông báo hệ thống</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f5f6fa; padding: 20px; margin: 0;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden;">
        <tr>
            <td style="background:#007bff; padding:20px; text-align:center; color:#fff; font-size:20px; font-weight:bold;">
                📨 Thông báo hệ thống
            </td>
        </tr>
        <tr>
            <td style="padding:20px; font-size:15px; color:#333;">
                <p style="margin:0 0 15px;">{{ $messageText }}</p>

                @if($link)
                    <p style="margin:20px 0; text-align:center;">
                        <a href="{{ url($link) }}" 
                           style="background:#28a745; color:#fff; padding:10px 20px; text-decoration:none; border-radius:5px; display:inline-block;">
                            👉 Xem chi tiết
                        </a>
                    </p>
                @endif
            </td>
        </tr>
        <tr>
            <td style="background:#f1f1f1; padding:15px; text-align:center; font-size:12px; color:#777;">
                © {{ date('Y') }} Công ty IT HireNow. Mọi quyền được bảo lưu.
            </td>
        </tr>
    </table>
</body>
</html>
