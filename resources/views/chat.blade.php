@auth
    @if(Auth::user()->role === 'job_seeker')
        <!-- ⭐ Icon việc làm yêu thích (nhỏ hơn) -->
        <a href="{{ route('favorites.index') }}"
           class="position-fixed bg-danger text-white rounded-circle d-flex justify-content-center align-items-center shadow"
           style="width: 35px; height: 35px; cursor: pointer; z-index: 8000; bottom: 85px; right: 25px; font-size: 18px;">
           <i class="bi bi-heart-fill"></i>
        </a>
    @endif
@endauth

<!-- 💬 Icon Chatbot -->
<div id="chatbot-toggle"
    class="position-fixed bg-primary text-white rounded-circle d-flex justify-content-center align-items-center shadow"
    style="width: 45px; height: 45px; cursor: pointer; z-index: 9000; bottom: 25px; right: 25px;"
    onclick="toggleChatbot(true)">
<i class="bi bi-chat-dots-fill"></i>
</div>


<div id="chatbot-widget" class="position-fixed bottom-0 end-0 m-4" style="z-index: 9999; width: 360px; display: none;">
    <div class="card shadow border-0 rounded-4 overflow-hidden chatbot-card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center p-2">
            <span>💬 Chatbot Tuyển Dụng</span>
            <div>
                <button type="button" class="btn btn-sm btn-light me-1" onclick="toggleFullScreen()"
                    id="fullscreen-toggle-btn">
                    <i class="bi bi-arrows-fullscreen"></i>
                </button>
                <button type="button" class="btn-close btn-close-white" onclick="toggleChatbot(false)"></button>
            </div>
        </div>

        <div class="card-body p-3" style="height: 280px; overflow-y: auto; background-color: #f8f9fa;" id="chat-log">
            <div class="chat-line chat-bot">
                <img src="https://cdn-icons-png.flaticon.com/512/4712/4712109.png" class="avatar" />
                <div class="chat-bubble">🤖 Xin chào {{ Auth::user()->name ?? 'guest' }}! Mình là Trợ Lý Tuyển Dụng, có
                    thể giúp gì cho bạn hôm nay?</div>
            </div>
        </div>

        <div class="card-footer bg-light p-2" style="overflow: visible;">
            <div id="quick-actions" class="d-flex gap-2 flex-wrap mb-2">
                <!-- Gợi ý sẽ render bằng JS theo role -->
            </div>

            <form id="chat-form" class="d-flex gap-2 align-items-center">
                <!-- Ẩn icon trong form nhập tin nhắn -->
                <input type="text" id="message" class="form-control rounded-pill px-3 py-2"
                    placeholder="Nhập câu hỏi..." required autocomplete="off">
                <button type="submit"
                    class="btn btn-primary rounded-circle d-flex justify-content-center align-items-center"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    #chat-log .chat-line {
        display: flex;
        align-items: flex-end;
        margin-bottom: 10px;
    }

    .chat-user {
        justify-content: flex-end;
        flex-direction: row;
    }

    .chat-bot {
        justify-content: flex-start;
        flex-direction: row;
    }

    .chat-bubble {
        padding: 10px 15px;
        border-radius: 18px;
        max-width: 75%;
        line-height: 1.5;
        word-wrap: break-word;
    }

    .chat-user .chat-bubble {
        background-color: #0d6efd;
        color: white;
        border-radius: 18px 18px 4px 18px;
        margin-right: 8px;
    }

    .chat-bot .chat-bubble {
        background-color: #e4e6eb;
        color: black;
        border-radius: 18px 18px 18px 4px;
        margin-left: 8px;
    }

    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
    }

    /* Ẩn icon chatbot trong form nhập tin nhắn */
    #chat-form .avatar {
        display: none;
    }

    /* Ẩn icon trong khung chat */
    .chat-bot .avatar {
        display: none;
    }

    .chatbot-fullscreen {
        width: 100vw !important;
        height: 100vh !important;
        max-width: none !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        margin: 0 !important;
        border-radius: 0 !important;
    }

    .chatbot-fullscreen .chatbot-card {
        height: 100vh !important;
        border-radius: 0 !important;
    }

    .chatbot-fullscreen .card-body {
        height: calc(100vh - 160px);
    }

    body.chatbot-locked {
        overflow: hidden !important;
    }

    #chatbot-widget,
    #chatbot-widget .card {
        transition: all 0.3s ease-in-out;
    }
</style>

<script>
    const userRole = "{{ Auth::user()->role ?? 'guest' }}";

    function renderQuickActions(role) {
        const container = document.getElementById('quick-actions');
        container.innerHTML = "";

        let list = [];

        if (["guest", "job_seeker", "admin"].includes(role)) {
            list.push({ text: "Tìm việc", query: "Tôi đang tìm việc làm" });
        }

        if (["employer", "admin"].includes(role)) {
            list.push({ text: "Đăng tin", query: "đăng tin" });
            list.push({ text: "Mua gói", query: "mua gói" });
        }

        list.forEach((btn) => {
            const button = document.createElement("button");
            button.className = "btn btn-sm btn-outline-primary";
            button.textContent = btn.text;
            button.onclick = () => quickAsk(btn.query);
            container.appendChild(button);
        });
    }

    function toggleChatbot(show) {
        const bot = document.getElementById("chatbot-widget");
        const toggle = document.getElementById("chatbot-toggle");
        const log = document.getElementById("chat-log");
        const card = bot.querySelector(".chatbot-card");

        if (show) {
            bot.style.display = "block";
            toggle.style.display = "none"; // Ẩn icon khi mở chatbot

            renderQuickActions(userRole);

            if (!bot.dataset.loaded) {
                fetch("/chatbot/history")
                    .then((res) => res.json())
                    .then((data) => {
                        data.forEach((item) => {
                            log.innerHTML += `
                            <div class="chat-line chat-user">
                                <div class="chat-bubble">${item.message}</div>
                                <img src="https://cdn-icons-png.flaticon.com/512/1144/1144760.png" class="avatar" />
                            </div>
                            <div class="chat-line chat-bot">
                                <div class="chat-bubble">${item.reply}</div>
                            </div>
                        `;
                        });
                        log.scrollTop = log.scrollHeight;
                        bot.dataset.loaded = "true";
                    });
            }
        } else {
            bot.style.display = "none";
            toggle.style.display = "flex"; // Hiển thị lại icon khi đóng chatbot
            document.body.classList.remove("chatbot-locked");
            bot.classList.remove("chatbot-fullscreen");
            card.classList.remove("chatbot-fullscreen");

            const icon = document
                .getElementById("fullscreen-toggle-btn")
                .querySelector("i");
            icon.classList.remove("bi-fullscreen-exit");
            icon.classList.add("bi-arrows-fullscreen");
        }
    }

    function toggleFullScreen() {
        const widget = document.getElementById("chatbot-widget");
        const card = widget.querySelector(".chatbot-card");
        const body = document.body;
        const icon = document
            .getElementById("fullscreen-toggle-btn")
            .querySelector("i");

        widget.classList.toggle("chatbot-fullscreen");
        card.classList.toggle("chatbot-fullscreen");

        if (widget.classList.contains("chatbot-fullscreen")) {
            body.classList.add("chatbot-locked");
            icon.classList.remove("bi-arrows-fullscreen");
            icon.classList.add("bi-fullscreen-exit");
        } else {
            body.classList.remove("chatbot-locked");
            icon.classList.remove("bi-fullscreen-exit");
            icon.classList.add("bi-arrows-fullscreen");
        }
    }

    function quickAsk(text) {
        document.getElementById("message").value = text;
        document.getElementById("chat-form").dispatchEvent(new Event("submit"));
    }

    document.getElementById("chat-form").addEventListener("submit", async function (e) {
        e.preventDefault();

        const input = document.getElementById("message");
        const submitBtn = this.querySelector('button[type="submit"]');
        const msg = input.value.trim();
        const log = document.getElementById("chat-log");
        const quickButtons = document.querySelectorAll("#quick-actions button");

        if (!msg) return;

        input.disabled = true;
        submitBtn.disabled = true;
        quickButtons.forEach((btn) => (btn.disabled = true));

        log.innerHTML += `
        <div class="chat-line chat-user">
            <div class="chat-bubble">${msg}</div>
            <img src="https://cdn-icons-png.flaticon.com/512/1144/1144760.png" class="avatar" />
        </div>
    `;

        const loadingId = "loading-" + Date.now();
        log.innerHTML += `
        <div class="chat-line chat-bot" id="${loadingId}">
            <img src="https://cdn-icons-png.flaticon.com/512/4712/4712109.png" class="avatar" />
            <div class="chat-bubble"><em>Đang trả lời...</em></div>
        </div>
    `;

        input.value = "";
        log.scrollTop = log.scrollHeight;

        try {
            const res = await fetch("/chatbot", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify({ message: msg }),
            });

            const data = await res.json();
            document.getElementById(loadingId)?.remove();

            log.innerHTML += `
            <div class="chat-line chat-bot">
                <div class="chat-bubble">${data.reply}</div>
            </div>
        `;
        } catch (err) {
            document.getElementById(loadingId)?.remove();
            log.innerHTML += `
            <div class="chat-line chat-bot">
                <div class="chat-bubble text-danger">Lỗi kết nối chatbot. Vui lòng thử lại.</div>
            </div>
        `;
        } finally {
            input.disabled = false;
            submitBtn.disabled = false;
            quickButtons.forEach((btn) => (btn.disabled = false));
            input.focus();
            log.scrollTop = log.scrollHeight;
        }
    });
</script>
