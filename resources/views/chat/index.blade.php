@extends('website.layouts.master1')

@push('styles')
    <style>
        #typing-indicator {
            display: none;
            align-items: center;
            gap: 10px;
            margin: 0 0 6px 8px;
            min-height: 32px;
            font-size: 15px;
            color: #0078fe;
            font-style: italic;
            font-weight: 500;
            transition: all 0.3s;
        }

        .typing-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 4px;
            border: 1px solid #e2e2e2;
        }

        .typing-dots {
            display: inline-flex;
            align-items: flex-end;
            gap: 3px;
        }

        .typing-dot {
            width: 7px;
            height: 7px;
            background: #0078fe;
            border-radius: 50%;
            animation: typing-bounce 1.1s infinite both;
            opacity: .9;
        }

        .typing-dot:nth-child(2) {
            animation-delay: .18s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: .36s;
        }

        @keyframes typing-bounce {

            0%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-8px);
            }
        }

        @media (max-width: 600px) {
            #typing-indicator {
                font-size: 14px;
                margin-left: 2px;
            }

            .typing-avatar {
                width: 18px;
                height: 18px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-header-area sec-overlay sec-overlay-black d-flex justify-content-center align-items-center text-center"
        data-bg-img="{{ asset('client/assets/img/banner/15.png') }}"
        style="max-height: 80px; height: 80px; padding: 0 !important;">
        &nbsp;
    </div>

    <div class="container py-4">
        <div class="row">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white fw-semibold">
                        <i class="fa-solid fa-comments me-2"></i> Cuộc trò chuyện
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse ($conversations as $conversation)
                            @php
                                $otherUser =
                                    $conversation->user_one === auth()->id()
                                        ? $conversation->userTwo
                                        : $conversation->userOne;
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
                                    @if ($conversation->unread_count > 0)
                                        <span class="badge bg-danger ms-auto align-self-center">
                                            {{ $conversation->unread_count }}
                                        </span>
                                    @endif
                                </a>
                            </li>

                        @empty
                            <li class="list-group-item text-muted">Không có cuộc trò chuyện nào.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
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
                        <div id="typing-indicator" class="d-inline-block px-3 py-2 rounded shadow-sm "></div>
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
        const conversationId = {{ $conversationId ? $conversationId : 'null' }};
        const typingUrl = {!! $conversationId ? '"' . route('chat.typing', $conversationId) . '"' : 'null' !!};
        const sendUrl = {!! $conversationId ? '"' . route('chat.send', $conversationId) . '"' : 'null' !!};
        const authId = {{ auth()->id() }};
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');
        const messageBox = document.getElementById('message-box');
        const typingIndicator = document.getElementById('typing-indicator');
        let typingTimeout = null;
        let lastTyped = 0;

        document.addEventListener('DOMContentLoaded', () => {
            if (messageBox) messageBox.scrollTop = messageBox.scrollHeight;

            // Nhận tin nhắn và typing
            if (window.Echo && conversationId) {
                window.Echo.private('chat.' + conversationId)
                    .listen('MessageSent', (e) => {
                        if (e.message.sender_id !== authId) {
                            appendMessage(false, e.message.message);
                        }
                    })
                    .listen('TypingEvent', (e) => {
                        if (e.userId !== authId) {
                            showTyping(e.userName, e.userAvatar);
                        }
                    });
            }

            // Gửi typing event (debounce ~1.2s)
            messageInput?.addEventListener('input', function() {
                if (!conversationId || !typingUrl) return;
                if (Date.now() - lastTyped > 1200) {
                    fetch(typingUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                        },
                    });
                    lastTyped = Date.now();
                }
            });

            // Gửi message
            chatForm?.addEventListener('submit', function(e) {
                e.preventDefault();
                const message = messageInput.value.trim();
                if (message === '' || !sendUrl) return;
                fetch(sendUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            message
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        appendMessage(true, message);
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

            // Hiện typing hiện đại, avatar, chấm động, tự ẩn sau 2.5s
            function showTyping(userName, userAvatar = '') {
                if (!typingIndicator) return;
                typingIndicator.innerHTML = `
                    ${userAvatar ? `<img src="${userAvatar}" class="typing-avatar" alt="avatar">` : ''}
                    <span>${userName} đang soạn tin nhắn</span>
                    <span class="typing-dots">
                        <span class="typing-dot"></span>
                        <span class="typing-dot"></span>
                        <span class="typing-dot"></span>
                    </span>
                `;
                typingIndicator.style.display = 'flex';
                if (typingTimeout) clearTimeout(typingTimeout);
                typingTimeout = setTimeout(() => {
                    typingIndicator.style.display = 'none';
                    typingIndicator.innerHTML = '';
                }, 2500);
            }
        });
    </script>
@endpush

<script>
    if (typeof window.Echo !== 'undefined') {
        console.log('Echo loaded, lắng nghe thông báo toàn cục...');

        window.Echo.channel('global-notification')
            .listen('GlobalNotificationEvent', function(data) { // <-- SỬA LẠI CHỖ NÀY!
                console.log('Đã nhận sự kiện toàn cục:', data);
                showGlobalNotification(data.message, data.link);
            });
    } else {
        console.error('Echo chưa được khởi tạo hoặc chưa kết nối Pusher!');
    }


    function showGlobalNotification(message, link) {
        // Loại bỏ toast cũ (nếu có)
        $('#global-toast').remove();

        // Tạo popup/toast
        let html = `<div id="global-toast" style="
            position:fixed;top:24px;right:24px;z-index:99999;
            background:#232323;color:#fff;padding:16px 32px;
            border-radius:8px;font-size:1.1rem;box-shadow:0 2px 12px #0006;
            display:flex;align-items:center;
        ">
            <span>${message}</span>
            ${link ? `<a href="${link}" style="color:#ffd700;text-decoration:underline;margin-left:12px;">Xem</a>` : ''}
            <span style="cursor:pointer;float:right;font-weight:bold;margin-left:16px;" onclick="$('#global-toast').fadeOut()">×</span>
        </div>`;
        $('body').append(html);
        setTimeout(() => {
            $('#global-toast').fadeOut();
        }, 10000);
    }
</script>
