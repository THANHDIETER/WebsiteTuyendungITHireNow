@if(session('success'))
    <div class="alert alert-success" style="color: green; font-weight: bold; margin-bottom: 10px;">
        {{ session('success') }}
    </div>
@endif

<h3>Phản hồi thư mời phỏng vấn</h3>

<form method="POST" action="{{ route('job_seeker.interviews.respond', $interview->id) }}">
    @csrf

    <label>Phản hồi:</label><br>
    <input type="radio" name="response" value="accepted" required> Chấp nhận<br>
    <input type="radio" name="response" value="declined"> Từ chối<br><br>

    <label>Ghi chú (tuỳ chọn):</label><br>
    <textarea name="note" rows="4" cols="50" placeholder="Bạn muốn nhắn gì thêm không?"></textarea><br><br>

    <button type="submit">Gửi phản hồi</button>
</form>
