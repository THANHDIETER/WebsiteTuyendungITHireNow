@extends('website.layouts.master')

@section('content')

    {{-- Banner/Header --}}
    <div class="page-header-area sec-overlay sec-overlay-black d-flex justify-content-center align-items-center text-center"
        data-bg-img="{{ asset('client/assets/img/banner/15.png') }}"
        style="max-height: 80px; height: 80px; padding: 0 !important;">
        &nbsp;
    </div>

    <div class="container py-4">
        <div class="row">

            {{-- Sidebar - Danh sách hội thoại --}}
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white fw-semibold">
                        <i class="fa-solid fa-comments me-2"></i> Cuộc trò chuyện
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse ($conversations as $conversation)
                            @php
                                $otherUser = $conversation->user_one === auth()->id() ? $conversation->userTwo : $conversation->userOne;
                                $isActive = isset($chatWith) && $chatWith->id === $otherUser->id;
                                $lastMsgTime = optional($conversation->latestMessage)->created_at
                                    ? $conversation->latestMessage->created_at->diffForHumans()
                                    : 'Chưa có tin nhắn';
                            @endphp
                            <li
                                class="list-group-item p-2 {{ $isActive ? 'bg-light border-start border-4 border-primary' : '' }}">
                                <a href="{{ route('chat.show', $conversation->id) }}"
                                    class="text-decoration-none d-flex align-items-center gap-2 {{ $isActive ? 'fw-bold text-dark' : 'text-muted' }}">
                                    <img src="{{ $otherUser->avatar ?? asset('client/assets/img/banner/15.png') }}"
                                        class="rounded-circle" width="40" height="40" alt="avatar">
                                    <div class="d-flex flex-column">
                                        <span>{{ $otherUser->name }}</span>
                                        <small class="text-muted">
                                            <i class="fa-regular fa-clock me-1"></i>
                                            {{ $lastMsgTime }}
                                        </small>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Không có cuộc trò chuyện nào.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- Main chat area --}}
            <div class="col-md-8">
                <div class="card shadow-sm h-100 d-flex flex-column">
                    @isset($messages)
                        <div class="card-header bg-success text-white d-flex align-items-center">
                            <img src="{{ $chatWith->avatar ?? asset('client/assets/img/banner/15.png') }}"
                                class="rounded-circle me-2" width="32" height="32" alt="avatar">
                            <div>
                                <strong>{{ $chatWith->name }}</strong>
                                <div class="text-white-50 small">Đang trò chuyện</div>
                            </div>
                        </div>

                        <div class="card-body overflow-auto flex-grow-1" style="max-height: 400px;" id="message-box">
                            @foreach ($messages as $msg)
                                <div
                                    class="mb-2 d-flex {{ $msg->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                                    <div
                                        class="d-inline-block px-3 py-2 rounded shadow-sm 
                                        {{ $msg->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-light text-dark' }}">
                                        {{ $msg->message }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Input form --}}
                        <div class="card-footer bg-white">
                            <form id="chat-form" class="d-flex gap-2 align-items-center">
                                @csrf
                                <input type="text" name="message" id="message-input" class="form-control rounded-pill px-4"
                                    placeholder="Nhập tin nhắn..." required autocomplete="off">
                                <button class="btn btn-primary rounded-pill px-3 py-1" type="submit">
                                    <i class="fa-solid fa-paper-plane me-1"></i> Gửi
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="card-body text-center text-muted py-5">
                            <i class="fa-regular fa-comments fa-2x mb-3"></i>
                            <p>Chọn một cuộc trò chuyện để bắt đầu.</p>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const conversationId = {{ $conversationId ?? 'null' }};
    const authId = {{ auth()->id() }};
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const messageBox = document.getElementById('message-box');

    document.addEventListener('DOMContentLoaded', () => {
        if (messageBox) messageBox.scrollTop = messageBox.scrollHeight;

        if (window.Echo && conversationId) {
            window.Echo.private('chat.' + conversationId)
                .listen('MessageSent', (e) => {
                    // Kiểm tra sender_id để tránh hiển thị lại tin nhắn của mình
                    if (e.message.sender_id !== authId) {
                        appendMessage(false, e.message.message);
                    }
                });
        }

        chatForm?.addEventListener('submit', function (e) {
            e.preventDefault();
            const message = messageInput.value.trim();
            if (message === '') return;

            fetch("{{ route('chat.send', $conversationId) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message })
            })
                .then(res => res.json())
                .then(data => {
                    appendMessage(true, message); // ✅ Hiển thị phía mình
                    messageInput.value = '';
                })
                .catch(err => {
                    console.error('Lỗi gửi tin nhắn:', err);
                    alert('Không gửi được tin nhắn.');
                });
        });

        function appendMessage(isMine, message) {
            const alignClass = isMine ? 'justify-content-end' : 'justify-content-start';
            const bubbleClass = isMine ? 'bg-primary text-white' : 'bg-light text-dark';

            const msgDiv = document.createElement('div');
            msgDiv.className = 'mb-2 d-flex ' + alignClass;
            msgDiv.innerHTML = `
                <div class="d-inline-block px-3 py-2 rounded shadow-sm ${bubbleClass}">
                    ${message}
                </div>
            `;
            messageBox.appendChild(msgDiv);
            messageBox.scrollTop = messageBox.scrollHeight;
        }
    });
</script>
@endpush
