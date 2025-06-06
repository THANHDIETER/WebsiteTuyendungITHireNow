@extends('layouts.admin') {{-- hoặc layouts.app nếu chưa tách layout --}}

@section('content')
<h2>📢 Gửi thông báo hệ thống</h2>

@if(session('success'))
    <div style="color:green;">{{ session('success') }}</div>
@endif

<form action="{{ route('admin.notifications.store') }}" method="POST">
    @csrf

    <label>Loại thông báo:</label>
    <input type="text" name="type" required>

    <label>Gửi đến:</label>
    <select name="user_id">
        <option value="all">Tất cả người dùng</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->email }}</option>
        @endforeach
    </select>

    <label>Nội dung:</label>
    <textarea name="message" required></textarea>

    <label>Link (nếu có):</label>
    <input type="text" name="link_url">

    <button type="submit">Gửi thông báo</button>
</form>
@endsection
