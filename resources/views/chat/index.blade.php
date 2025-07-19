@extends('website.layouts.master')

@section('content')
    <div class="page-header-area sec-overlay sec-overlay-black d-flex justify-content-center align-items-center text-center"
        data-bg-img="{{ asset('client/assets/img/banner/15.png') }}"
        style="max-height: 80px; height: 80px; padding: 0 !important;">
        &nbsp; 
    </div>

    <div class="container py-4">
        <div class="row">

            {{-- Sidebar: Danh sách hội thoại --}}
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">
                        Cuộc trò chuyện
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse ($conversations as $conversation)
                            @php
                                $otherUser = $conversation->user_one === auth()->id()
                                    ? $conversation->userTwo
                                    : $conversation->userOne;
                                $isActive = isset($chatWith) && $chatWith->id === $otherUser->id;
                            @endphp
                            <li
                                class="list-group-item p-2 {{ $isActive ? 'bg-light border-start border-4 border-primary' : '' }}">
                                <a href="{{ route('chat.show', $conversation->id) }}"
                                    class="text-decoration-none d-block {{ $isActive ? 'fw-bold text-dark' : 'text-muted' }}">
                                    <i class="fa-regular fa-user me-2"></i> {{ $otherUser->name }}
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Không có cuộc trò chuyện nào.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- Main chat box --}}
            <div class="col-md-8">
                <div class="card shadow-sm h-100">
                    @isset($messages)
                        <div class="card-header bg-success text-white">
                            Đang trò chuyện với: <strong>{{ $chatWith->name }}</strong>
                        </div>

                        <div class="card-body" style="height: 400px; overflow-y: auto;" id="message-box">
                            @foreach ($messages as $msg)
                                <div
                                    class="mb-2 d-flex {{ $msg->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                                    <div
                                        class="px-3 py-2 rounded {{ $msg->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-light text-dark' }}">
                                        {{ $msg->message }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Form gửi tin nhắn --}}
                        <div class="card-footer bg-white">
                            <form action="{{ route('chat.send', $conversationId) }}" method="POST"
                                class="d-flex gap-2 align-items-center">
                                @csrf
                                <input type="text" name="message" class="form-control rounded-pill px-4"
                                    placeholder="Nhập tin nhắn..." required autocomplete="off">
                                <button class="btn btn-primary btn-sm rounded-pill px-3 py-1" type="submit">
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
        const box = document.getElementById('message-box');
        if (box) box.scrollTop = box.scrollHeight;
    </script>
@endpush