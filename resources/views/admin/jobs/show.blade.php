<div class="container py-4">
    <h2 class="h5 fw-bold text-primary mb-4">📄 Chi tiết tin tuyển dụng #{{ $job->id }}</h2>

    <div class="card shadow-sm border-0 p-4 rounded-4">
        <div class="row g-3">
            <div class="col-md-6"><span>📝 <strong>Tiêu đề: </strong> {{ $job->title }}</span></div>
            <div class="col-md-6"><span>🏢 <strong>Công ty: </strong> {{ $job->company->name }}</span></div>

            <div class="col-md-6"><span>📂 <strong>Danh mục: </strong> {{ $job->category->name }}</span></div>
            <div class="col-md-6"> <span>💼 <strong>Hình thức: </strong>{{ $job->job_type_label }}</span></div>

            <div class="col-md-6"><span>📍 <strong>Khu vực: </strong> {{ $job->location }}</span></div>
            <div class="col-md-6"><span>🏠 <strong>Địa chỉ: </strong> {{ $job->address }}</span></div>

            <div class="col-md-6"><span>🌐 <strong>Remote: </strong> {{ $job->remote_policy ?? '-' }}</span></div>
            <div class="col-md-6"><span>🗣 <strong>Ngôn ngữ: </strong> {{ $job->language ?? '-' }}</span></div>

            <div class="col-md-6"><span>📊 <strong>Kinh nghiệm: </strong> {{ $job->experience ?? '-' }}</span></div>
            <div class="col-md-6"><span>🎯 <strong>Cấp bậc: </strong> {{ $job->level ?? '-' }}</span></div>

            <div class="col-md-6"><span>💰 <strong>Mức lương: </strong> {{ number_format($job->salary_min) }} -
                    {{ number_format($job->salary_max) }} {{ $job->currency }}</span></div>
            <div class="col-md-6"><span>📅 <strong>Hạn nộp: </strong>
                    {{ optional($job->deadline)?->format('d/m/Y') ?? '-' }}</span></div>

            <div class="col-md-6"><span>🔗 <strong>Link ứng tuyển: </strong>
                    @if ($job->apply_url)
                        <a href="{{ $job->apply_url }}" target="_blank">{{ $job->apply_url }}</a>
                    @else
                        Không có
                    @endif
                </span></div>

            <div class="col-md-6"><span>👁‍🗨 <strong>Lượt xem: </strong> {{ $job->views }}</span></div>

            <div class="col-md-6">
                <strong>📌 Trạng thái:</strong> {!! $job->status_badge !!}
            </div>

            <div class="col-md-6"><span>🔍 <strong>Index Google: </strong>
                    {!! $job->search_index ? '<span class="text-success">✔ Có</span>' : '<span class="text-danger">✖ Không</span>' !!}
                </span></div>

            <div class="col-md-6">
                <span>⭐ <strong>Nổi bật: </strong> {!! $job->featured_badge!!}</span>
            </div>

            <div class="col-md-6"><span>🔖 <strong>Meta title: </strong> {{ $job->meta_title ?? '-' }}</span></div>
            <div class="col-md-6"><span>📝 <strong>Meta description: </strong>
                    {{ $job->meta_description ?? '-' }}</span></div>
        </div>

        <hr class="my-4">

        <div class="mb-3">
            <h6 class="fw-bold">📃 Mô tả công việc</h6>
            <p class="white-space-pre-line">{!! $job->description !!}</p>
        </div>
        <hr>
        <div class="mb-3">
            <h6 class="fw-bold">📌 Yêu cầu công việc</h6>
            <p class="white-space-pre-line">{{ $job->requirements }}</p>
        </div>
        <hr>
<<<<<<< HEAD
        {{-- @if (is_array($job->benefits) || is_string($job->benefits))
=======
        @if (is_array($job->benefits) || is_string($job->benefits))
>>>>>>> b9415a3b41f90f6ec4df40f97d47fc6235287f05
            <div class="mb-3">
                <h6 class="fw-bold">🎁 Quyền lợi</h6>
                <ul class="ps-3">
                    @foreach (is_array($job->benefits) ? $job->benefits : json_decode($job->benefits, true) as $benefit)
                        <li>{{ $benefit }}</li>
                    @endforeach
                </ul>
            </div>
<<<<<<< HEAD
        @endif --}}
=======
        @endif
>>>>>>> b9415a3b41f90f6ec4df40f97d47fc6235287f05
        <hr>
        <div class="mb-2">
            <h6 class="fw-bold">🛠 Kỹ năng</h6>
            @forelse ($job->skills as $skill)
                <span class="badge bg-primary me-1">{{ $skill->name }}{{ $skill->pivot->required ? ' (*)' : '' }}</span>
            @empty
                <span class="text-muted">Không có kỹ năng</span>
            @endforelse
        </div>

        <div class="text-end text-muted small mt-3">
            🕒 Ngày tạo: {{ $job->created_at->format('d/m/Y H:i') }}
        </div>
    </div>
</div>