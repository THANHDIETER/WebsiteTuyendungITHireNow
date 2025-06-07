<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Hóa đơn thanh toán</title>
  <style>
    @page { margin: 30px; }
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 14px;
      color: #212529;
    }

    .container {
      border-radius: 8px;
      padding: 30px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .company-info {
      font-size: 13px;
      line-height: 1.6;
    }

    .logo {
      max-height: 60px;
    }

    h1 {
      text-align: center;
      font-size: 20px;
      text-transform: uppercase;
      margin: 20px 0;
      color: #004085;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    td, th {
      padding: 8px;
      border: 1px solid #ddd;
    }

    th {
      background-color: #f8f9fa;
      text-align: left;
      color: #333;
    }

    .section-title {
      font-weight: bold;
      margin-top: 20px;
      margin-bottom: 10px;
      font-size: 15px;
      color: #004085;
    }

    .footer {
      font-size: 13px;
      margin-top: 20px;
      color: #666;
    }

    .signature {
      margin-top: 50px;
      text-align: right;
      font-size: 13px;
    }

    .signature em {
      display: block;
      margin-bottom: 50px;
    }
  </style>
</head>
<body>
  <div class="container">
    {{-- Header --}}
    <div class="header">
      <div class="company-info">
        <strong>CÔNG TY TNHH HIRENOW</strong><br>
        123 Lê Văn Sỹ, Phường 1, Q. Tân Bình, TP.HCM<br>
        Email: contact@hirenow.vn<br>
        Website: https://hirenow.vn
      </div>
      <div>
        <img src="{{ public_path('images/logo/logo.png') }}" alt="Logo" class="logo">
      </div>
    </div>

    <h1>HÓA ĐƠN THANH TOÁN</h1>

    {{-- Thông tin thanh toán --}}
    <div class="section-title">Thông tin hóa đơn</div>
    <table>
      <tr>
        <td><strong>Số hóa đơn:</strong></td>
        <td>{{ $payment->invoice_number }}</td>
        <td><strong>Ngày thanh toán:</strong></td>
        <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y') }}</td>
      </tr>
      <tr>
        <td><strong>Khách hàng:</strong></td>
        <td>{{ $payment->user->name ?? '---' }}</td>
        <td><strong>Email:</strong></td>
        <td>{{ $payment->user->email ?? '---' }}</td>
      </tr>
    </table>

    {{-- Chi tiết dịch vụ --}}
    <div class="section-title">Chi tiết dịch vụ</div>
    <table>
      <thead>
        <tr>
          <th>Gói</th>
          <th>Giá</th>
          <th>Phương thức</th>
          <th>Cổng thanh toán</th>
          <th>Trạng thái</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ $payment->package->name }}</td>
          <td>{{ number_format($payment->amount, 0, ',', '.') }} {{ $payment->currency }}</td>
          <td>{{ $payment->payment_method ?? '---' }}</td>
          <td>{{ $payment->payment_gateway ?? '---' }}</td>
          <td>{{ ucfirst($payment->status) }}</td>
        </tr>
      </tbody>
    </table>

    {{-- Ghi chú --}}
    <div class="footer">
      Mã giao dịch: <strong>{{ $payment->transaction_id }}</strong><br>
      Xin chân thành cảm ơn quý khách đã sử dụng dịch vụ!
    </div>

    {{-- Chữ ký --}}
    <div class="signature">
      <em>Đại diện công ty</em>
      _____________________________<br>
      (Ký tên & đóng dấu)
    </div>
  </div>
</body>
</html>
