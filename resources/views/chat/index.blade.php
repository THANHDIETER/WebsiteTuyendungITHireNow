@extends('website.layouts.master')

@section('content')
<div class="container mt-4">
    <div class="row">
        {{-- Sidebar: Danh sách hội thoại --}}
        <div class="col-md-4 border-end">
            <h5>Cuộc trò chuyện</h5>
            <ul class="list-group">
                @foreach ($conversations as $conversation)
                    @php
                        $otherUser = $conversation->user_one === auth()->id()
                            ? $conversation->userTwo
                            : $conversation->userOne;
                    @endphp
                    <li class="list-group-item">
                        <a href="{{ route('chat.show', $conversation->id) }}">
                            {{ $otherUser->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Main chat box --}}
        <div class="col-md-8">
            @isset($messages)
                <h5>Đang trò chuyện với: {{ $chatWith->name }}</h5>
                <div class="border p-3 mb-3" style="height: 400px; overflow-y: auto;" id="message-box">
                    @foreach ($messages as $msg)
                        <div class="mb-2 {{ $msg->sender_id === auth()->id() ? 'text-end' : '' }}">
                            <span class="badge bg-{{ $msg->sender_id === auth()->id() ? 'primary' : 'secondary' }}">
                                {{ $msg->message }}
                            </span>
                        </div>
                    @endforeach
                </div>

                {{-- Gửi tin nhắn --}}
                <form action="{{ route('chat.send', $conversationId) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="message" class="form-control" placeholder="Nhập tin nhắn..." required>
                        <button class="btn btn-success" type="submit">Gửi</button>
                    </div>
                </form>
            @else
                <p>Chọn một cuộc trò chuyện để bắt đầu.</p>
            @endisset
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    const box = document.getElementById('message-box');
    if (box) box.scrollTop = box.scrollHeight;
</script>
@endpush
