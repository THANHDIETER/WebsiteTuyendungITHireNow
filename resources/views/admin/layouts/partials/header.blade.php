
  <header class="page-header row justify-content-between align-items-center bg-white">
      <div class="logo-wrapper d-flex align-items-center col-4" style="padding-left: 80px;">
          <div class="d-flex justify-content-center align-items-center" style="height: 70px; width: 90px;">
              @php $logo = \App\Models\Logo::where('type', 'admin')->where('is_active', true)->first(); @endphp
              <a href="{{ route('home') }}">
                  <img src="{{ $logo ? asset('storage/' . $logo->image_path) : "" }}"
                      alt="Admin Logo" class="logo-img" style="height:60px; width: auto;">
              </a>
          </div>
          <a class="close-btn ms-4" href="javascript:void(0)">
              <div class="toggle-sidebar">
                  <div class="line"></div>
                  <div class="line"></div>
                  <div class="line"></div>
              </div>
          </a>
      </div>

      <div class="page-main-header d-flex align-items-center col-auto">
          <div class="nav-right">
              <ul class="header-right">
                  <li class="modes d-flex">
                      <a href="#" class="dark-mode text-dark" title="Chế độ tối">
                          <i class="bi bi-moon-fill svg-color fs-5"></i>
                      </a>
                  </li>

                  <!-- Trang chủ -->
                  <li class="modes d-flex">
                      <a href="{{ route('home') }}" class="text-dark" title="Trang chủ">
                          <i class="bi bi-house-door-fill svg-color fs-5"></i>
                      </a>
                  </li>

                  <!-- Nhà tuyển dụng -->
                  <li class="modes d-flex">
                      <a href="{{ route('employer.dashboard') }}" class="text-dark" title="Nhà tuyển dụng">
                          <i class="bi bi-person-badge svg-color fs-5"></i>
                      </a>
                  </li>

                  {{-- 🔔 Notifications: 3 item đầu + cuộn trong dropdown + nút "Đánh dấu tất cả đã đọc" --}}
                  <li class="custom-dropdown" id="admin-noti-dropdown">
                      <a href="javascript:void(0)" id="notification-toggle" aria-label="Thông báo">
                          <svg class="svg-color circle-color" width="24" height="24" viewBox="0 0 24 24"
                              fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path d="M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor"
                                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                              <path d="M13.73 21a2 2 0 01-3.46 0" stroke="currentColor" stroke-width="2"
                                  stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                      </a>

                      @php
                      $unreadCount = auth()->check() ? auth()->user()->unreadNotifications()->count() : 0;
                      $notifications = auth()->check()
                      ? auth()->user()->notifications()->latest()->take(30)->get()
                      : collect();
                      @endphp

                      <span class="badge rounded-pill badge-secondary" id="noti-count">
                          {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                      </span>

                      <div class="custom-menu notification-dropdown py-0 noti-card shadow">
                          {{-- Header --}}
                          <div class="noti-card__header d-flex align-items-center justify-content-between">
                              <div class="d-flex align-items-center gap-2">
                                  <div class="noti-card__chip d-flex align-items-center justify-content-center">
                                      <i class="bi bi-bell-fill"></i>
                                  </div>
                                  <div class="fw-semibold">Thông báo</div>
                              </div>
                              <a href="{{ route('admin.notifications.index') }}" class="noti-card__link">Xem tất cả</a>
                          </div>

                          {{-- Vùng cuộn (JS sẽ set chiều cao đúng bằng 3 item đầu) --}}
                          <div id="noti-scroll" class="noti-card__list">
                              <ul class="list-unstyled m-0" id="noti-list">
                                  @if ($notifications->count())
                                  @foreach ($notifications as $noti)
                                  @php
                                  $data = $noti->data ?? [];
                                  $msg = is_string(data_get($data, 'message'))
                                  ? data_get($data, 'message')
                                  : (data_get($data, 'message')
                                  ? json_encode(data_get($data, 'message'), JSON_UNESCAPED_UNICODE)
                                  : (data_get($data, 'title') ?:
                                  'Bạn có thông báo mới!'));
                                  $link = data_get($data, 'link_url', '#');
                                  $isRead = !is_null($noti->read_at);
                                  @endphp
                                  <li class="noti-item {{ $isRead ? 'is-read' : '' }}"
                                      data-id="{{ $noti->id }}" data-read="{{ $isRead ? '1' : '0' }}">
                                      <a class="noti-item__inner" href="{{ $link }}">
                                          <div class="noti-item__avatar"><i class="bi bi-bell"></i></div>
                                          <div class="noti-item__body">
                                              <div class="noti-item__title">{{ $msg }}</div>
                                              <div class="noti-item__meta">
                                                  {{ $noti->created_at->diffForHumans() }}
                                              </div>
                                          </div>
                                          <span class="noti-item__dot" aria-hidden="true"></span>
                                      </a>
                                  </li>
                                  @endforeach
                                  @else
                                  <li class="noti-empty empty-row">
                                      <div class="noti-empty__icon"><i class="bi bi-bell-slash"></i></div>
                                      <div class="noti-empty__text">Chưa có thông báo</div>
                                  </li>
                                  @endif
                              </ul>
                          </div>

                          {{-- Footer: nút đánh dấu tất cả đã đọc + liên kết xem tất cả --}}
                          <div class="noti-card__footer">
                              @php
                              $readAllUrl = \Illuminate\Support\Facades\Route::has('admin.notifications.readAll')
                              ? route('admin.notifications.readAll')
                              : null;
                              @endphp
                              <button id="read-all-btn" type="button" class="btn btn-sm btn-outline-secondary"
                                  {{ $readAllUrl ? '' : 'disabled' }} data-action="{{ $readAllUrl ?? '' }}">
                                  Đánh dấu tất cả đã đọc
                              </button>
                              <a href="{{ route('admin.notifications.index') }}"
                                  class="btn btn-sm btn-link text-secondary">Xem tất cả</a>
                          </div>
                      </div>
                  </li>

                  <li class="profile-dropdown custom-dropdown">
                      <div class="d-flex align-items-center">
                          <img loading="lazy" src="{{ asset('assets/images/profile.png') }}" alt="">
                          <div class="flex-grow-1">
                              <h5>
                                  @if (auth()->check())
                                  {{ auth()->user()->name }}
                                  <sup class="text-danger" style="font-size: 0.7em;">{{ auth()->user()->id }}</sup>
                                  @else
                                  <span class="text-muted">Guest</span>
                                  @endif
                              </h5>
                              <span>{{ auth()->check() ? auth()->user()->email : 'Chưa đăng nhập' }}</span>
                          </div>
                      </div>
                  </li>

              </ul>
          </div>
      </div>


  </header>

  @if (session('access_token'))
  <script>
      localStorage.setItem('access_token', "{{ session('access_token') }}");
  </script>
  @endif

  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>

  <script>
      // Dark Mode
      document.addEventListener("DOMContentLoaded", function() {
          const btn = document.querySelector('.dark-mode');
          if (btn) {
              btn.addEventListener('click', function(e) {
                  e.preventDefault();
                  document.documentElement.classList.toggle('dark');
                  localStorage.setItem('theme', document.documentElement.classList.contains('dark') ?
                      'dark' : 'light');
              });
          }
          if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');
      });

      // Echo/Pusher
      window.Pusher = Pusher;
      window.Echo = new Echo({
          broadcaster: 'pusher',
          key: '{{ config('
          broadcasting.connections.pusher.key ', '
          1 ea633f39dfb08c3c0c2 ') }}',
          cluster: '{{ config('
          broadcasting.connections.pusher.options.cluster ', '
          ap1 ') }}',
          forceTLS: true,
      });

      // JSON detail URL (admin) - chỉ dùng nếu có route
        const NOTI_DETAIL_URL_TMPL = @json(
            \Illuminate\Support\Facades\Route::has('admin.notifications.json')
                ? route('admin.notifications.json', ['id' => '__ID__'])
                : null
        );

      // Keep height = exactly 3 items
      function setNotiScrollHeight() {
          const scroll = document.getElementById('noti-scroll');
          const list = document.getElementById('noti-list');
          if (!scroll || !list) return;

          const items = list.querySelectorAll('li.noti-item');
          if (items.length === 0) {
              scroll.style.maxHeight = '0px';
              return;
          }

          const firstRect = items[0].getBoundingClientRect();
          const target = items[Math.min(2, items.length - 1)];
          const targetRect = target.getBoundingClientRect();
          const visibleH = Math.max(0, targetRect.bottom - firstRect.top) + 10;
          scroll.style.maxHeight = visibleH + 'px';
          scroll.style.overflowY = 'auto';
      }
      document.addEventListener('DOMContentLoaded', setNotiScrollHeight);
      window.addEventListener('resize', setNotiScrollHeight);

      // Chỉ cuộn dropdown, không cuộn trang
      const scrollBox = document.getElementById('noti-scroll');
      if (scrollBox) {
          scrollBox.addEventListener('wheel', function(e) {
              const atTop = this.scrollTop === 0;
              const atBottom = Math.ceil(this.scrollTop + this.clientHeight) >= this.scrollHeight;
              if ((atTop && e.deltaY < 0) || (atBottom && e.deltaY > 0)) e.preventDefault();
          }, {
              passive: false
          });
      }

      // Recalc khi list thay đổi & dropdown đang mở
      const listUl = document.getElementById('noti-list');
      if (listUl) {
          new MutationObserver(() => setNotiScrollHeight()).observe(listUl, {
              childList: true
          });
      }

      // Fallback JSON khi payload thiếu
      async function resolveNotificationPayload(evt) {
          const d = evt?.data || {};
          let message = (typeof d.message === 'string' && d.message.trim() !== '') ? d.message : null;
          let link = (typeof d.link_url === 'string' && d.link_url.trim() !== '') ? d.link_url : null;
          if (message && link) return {
              message,
              link
          };

          if (!NOTI_DETAIL_URL_TMPL) {
              return {
                  message: message || d.title || 'Bạn có thông báo mới!',
                  link: link || '#'
              };
          }

          try {
              const url = NOTI_DETAIL_URL_TMPL.replace('__ID__', evt.id);
              const res = await fetch(url, {
                  headers: {
                      'Accept': 'application/json'
                  },
                  credentials: 'same-origin'
              });
              if (res.ok) {
                  const j = await res.json();
                  return {
                      message: (j.message && j.message.trim() !== '') ? j.message : (message || d.title ||
                          'Bạn có thông báo mới!'),
                      link: (j.link_url && j.link_url.trim() !== '') ? j.link_url : (link || '#'),
                  };
              }
          } catch (_) {}
          return {
              message: message || d.title || 'Bạn có thông báo mới!',
              link: link || '#'
          };
      }

      // Realtime: badge ++, prepend item
      const userId = {{ auth()->id() ?? 'null' }};
      };
      if (userId && window.Echo) {
          window.Echo.private(`App.Models.User.${userId}`)
              .notification(async (evt) => {
                  const badge = document.getElementById('noti-count');
                  const list = document.getElementById('noti-list');

                  // badge
                  if (badge) {
                      let txt = (badge.textContent || '').trim();
                      let c = (txt === '99+') ? 99 : parseInt(txt) || 0;
                      c = isNaN(c) ? 0 : c + 1;
                      badge.textContent = c > 99 ? '99+' : c;
                      badge.style.display = 'inline-block';
                  }

                  const payload = await resolveNotificationPayload(evt);

                  if (list) {
                      list.querySelectorAll('.empty-row').forEach(el => el.remove());

                      const li = document.createElement('li');
                      li.className = 'noti-item';
                      li.setAttribute('data-id', evt.id || '');
                      li.setAttribute('data-read', '0');
                      li.innerHTML = `
            <a class="noti-item__inner" href="${payload.link}">
              <div class="noti-item__avatar"><i class="bi bi-bell"></i></div>
              <div class="noti-item__body">
                <div class="noti-item__title">${payload.message}</div>
                <div class="noti-item__meta">Vừa xong</div>
              </div>
              <span class="noti-item__dot" aria-hidden="true"></span>
            </a>
          `;

                      const first = list.querySelector('.noti-item');
                      if (first) list.insertBefore(li, first);
                      else list.prepend(li);

                      // giới hạn ~50 item
                      const items = list.querySelectorAll('.noti-item');
                      if (items.length > 50)
                          for (let i = 50; i < items.length; i++) items[i].remove();

                      setNotiScrollHeight();
                  }
              });
      }

      // Click => mark-as-read => update badge theo server + điều hướng
      document.addEventListener('DOMContentLoaded', function() {
          const list = document.getElementById('noti-list');
          const badge = document.getElementById('noti-count');
          const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
          if (!list) return;

          const readUrlTmpl = "{{ route('admin.notifications.read', '__ID__') }}";

          list.addEventListener('click', async function(e) {
              const a = e.target.closest('a.noti-item__inner');
              const li = e.target.closest('li.noti-item[data-id]');
              if (!a || !li) return;

              if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
              e.preventDefault();

              const id = li.getAttribute('data-id');
              const href = a.getAttribute('href') || '#';

              try {
                  const res = await fetch(readUrlTmpl.replace('__ID__', id), {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': csrf,
                          'Accept': 'application/json'
                      },
                      credentials: 'same-origin',
                      body: JSON.stringify({})
                  });

                  if (res.ok) {
                      // Nếu controller trả unread_count thì cập nhật; nếu không, chỉ làm mờ item
                      let c;
                      try {
                          const data = await res.json();
                          c = parseInt(data.unread_count ?? NaN);
                      } catch (_) {}
                      if (badge && Number.isFinite(c)) {
                          badge.textContent = c > 99 ? '99+' : c;
                          badge.style.display = c > 0 ? 'inline-block' : 'none';
                      }
                      li.classList.add('is-read');
                      li.setAttribute('data-read', '1');
                  }
              } catch (err) {
                  console.error('Mark-as-read error:', err);
              } finally {
                  if (href && href !== '#') window.location.href = href;
              }
          });
      });

      // Đánh dấu tất cả đã đọc (footer button)
      document.addEventListener('DOMContentLoaded', function() {
          const btn = document.getElementById('read-all-btn');
          const list = document.getElementById('noti-list');
          const badge = document.getElementById('noti-count');
          const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

          if (!btn) return;
          const action = btn.getAttribute('data-action');

          if (!action) {
              // Chưa có route -> ẩn/disable nút cho gọn
              btn.disabled = true;
              btn.title = 'Vui lòng thêm route admin.notifications.readAll để dùng tính năng này';
              return;
          }

          btn.addEventListener('click', async function() {
              btn.disabled = true;
              const orig = btn.textContent;
              btn.textContent = 'Đang xử lý...';

              try {
                  const res = await fetch(action, {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': csrf,
                          'Accept': 'application/json'
                      },
                      credentials: 'same-origin',
                      body: JSON.stringify({})
                  });

                  if (res.ok) {
                      let unread = 0;
                      try {
                          const data = await res.json();
                          unread = parseInt(data.unread_count ?? 0);
                      } catch (_) {}
                      if (badge) {
                          badge.textContent = '0';
                          badge.style.display = 'none';
                      }
                      // đánh dấu mờ toàn bộ item trong dropdown
                      if (list) {
                          list.querySelectorAll('.noti-item').forEach(el => {
                              el.classList.add('is-read');
                              el.setAttribute('data-read', '1');
                          });
                      }
                  }
              } catch (err) {
                  console.error('Read-all error:', err);
              } finally {
                  btn.disabled = false;
                  btn.textContent = orig;
              }
          });
      });
  </script>

  <style>
      /* Card styles (đồng bộ với web) */
      .noti-card {
          width: 360px;
          border: none;
          border-radius: 14px;
          box-shadow: 0 12px 28px rgba(0, 0, 0, .16), 0 2px 4px rgba(0, 0, 0, .08);
          overflow: hidden;
      }

      .noti-card__header {
          padding: 10px 14px;
          background: linear-gradient(135deg, #2563eb 0%, #3b82f6 50%, #60a5fa 100%);
          color: #fff;
      }

      .noti-card__chip {
          width: 28px;
          height: 28px;
          border-radius: 50%;
          background: rgba(255, 255, 255, .18);
          backdrop-filter: blur(6px);
          font-size: 16px;
      }

      .noti-card__link {
          color: rgba(255, 255, 255, .9);
          text-decoration: none;
          font-size: .9rem;
      }

      .noti-card__link:hover {
          text-decoration: underline;
      }

      .noti-card__list {
          padding: 6px 0;
          background: var(--noti-bg, #fff);
          max-height: 320px;
          /* sẽ bị JS override, giữ làm fallback */
          overflow-y: auto;
          overscroll-behavior: contain;
          -webkit-overflow-scrolling: touch;
      }

      .noti-card__footer {
          position: sticky;
          bottom: 0;
          display: flex;
          gap: .5rem;
          justify-content: space-between;
          align-items: center;
          padding: 8px 12px;
          background: linear-gradient(180deg, rgba(0, 0, 0, .02), rgba(0, 0, 0, .06));
          backdrop-filter: blur(6px);
      }

      /* Item */
      .noti-item+.noti-item {
          border-top: 1px solid rgba(0, 0, 0, .05);
      }

      .noti-item__inner {
          display: grid;
          grid-template-columns: 36px 1fr auto;
          gap: 10px;
          align-items: start;
          padding: 10px 14px;
          text-decoration: none;
          transition: background .15s ease, transform .06s ease;
      }

      .noti-item__inner:hover {
          background: rgba(0, 0, 0, .04);
      }

      .noti-item__inner:active {
          transform: scale(.996);
      }

      .noti-item__avatar {
          width: 36px;
          height: 36px;
          border-radius: 10px;
          background: #eef2ff;
          color: #4f46e5;
          display: grid;
          place-items: center;
          font-size: 18px;
      }

      .noti-item__body {
          min-width: 0;
      }

      .noti-item__title {
          font-size: .95rem;
          line-height: 1.3;
          color: #111827;
          font-weight: 600;
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
          overflow: hidden;
      }

      .noti-item__meta {
          font-size: .8rem;
          color: #6b7280;
          margin-top: 2px;
      }

      .noti-item__dot {
          width: 10px;
          height: 10px;
          border-radius: 50%;
          background: #ef4444;
          margin-top: 4px;
          box-shadow: 0 0 0 3px rgba(239, 68, 68, .18);
      }

      .noti-item.is-read .noti-item__title {
          font-weight: 500;
          color: #374151;
      }

      .noti-item.is-read .noti-item__dot {
          visibility: hidden;
      }

      .noti-empty {
          padding: 24px 12px;
          text-align: center;
          color: #6b7280;
      }

      .noti-empty__icon {
          font-size: 28px;
          opacity: .5;
          margin-bottom: 6px;
      }

      html.dark .noti-card__list {
          --noti-bg: #0b1220;
      }

      html.dark .noti-item__inner:hover {
          background: rgba(255, 255, 255, .06);
      }

      html.dark .noti-item__title {
          color: #e5e7eb;
      }

      html.dark .noti-item__meta {
          color: #9ca3af;
      }

      html.dark .noti-item.is-read .noti-item__title {
          color: #cbd5e1;
      }
  </style>