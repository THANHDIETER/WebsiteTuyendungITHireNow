<div class="container">
    <h2 class="h5 fw-bold text-primary mb-4"><i class="fa-solid fa-file-lines me-1"></i>Chi tiết tin tuyển dụng
        #{{ $job->id }}</h2>

    <div class="card shadow-sm border-0 p-4 rounded-4">
        <div class="row g-3">
            <div class="col-md-6"><i class="fa-solid fa-pen me-1"></i><strong>Tiêu đề: </strong> {{ $job->title }}</div>
            <div class="col-md-6"><i class="fa-solid fa-building me-1"></i><strong>Công ty: </strong>
                {{ $job->company->name }}</div>

            <div class="col-md-6"><i class="fa-solid fa-folder-open me-1"></i><strong>Danh mục: </strong>
                {{ $job->category->name }}</div>
            <div class="col-md-6"><i class="fa-solid fa-briefcase me-1"></i><strong>Hình thức: </strong>
                {{ $job->job_type_label }}</div>

            <div class="col-md-6"><i class="fa-solid fa-location-dot me-1"></i><strong>Khu vực: </strong>
                {{ $job->location }}</div>
            <div class="col-md-6"><i class="fa-solid fa-house me-1"></i><strong>Địa chỉ: </strong> {{ $job->address }}
            </div>

            <div class="col-md-6"><i class="fa-solid fa-globe me-1"></i><strong>Remote: </strong>
                {{ $job->remote_policy ?? '-' }}</div>
            <div class="col-md-6"><i class="fa-solid fa-language me-1"></i><strong>Ngôn ngữ: </strong>
                {{ $job->language ?? '-' }}</div>

            <div class="col-md-6"><i class="fa-solid fa-chart-line me-1"></i><strong>Kinh nghiệm: </strong>
                {{ $job->experience ?? '-' }}</div>
            <div class="col-md-6"><i class="fa-solid fa-bullseye me-1"></i><strong>Cấp bậc: </strong>
                {{ $job->level ?? '-' }}</div>

            <div class="col-md-6"><i class="fa-solid fa-money-bill-wave me-1"></i><strong>Mức lương: </strong>
                {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency }}</div>
            <div class="col-md-6"><i class="fa-solid fa-calendar-day me-1"></i><strong>Hạn nộp: </strong>
                {{ optional($job->deadline)?->format('d/m/Y') ?? '-' }}</div>

            <div class="col-md-6"><i class="fa-solid fa-link me-1"></i><strong>Link ứng tuyển: </strong>
                @if ($job->apply_url)
                    <a href="{{ $job->apply_url }}" target="_blank">{{ $job->apply_url }}</a>
                @else
                    Không có
                @endif
            </div>

            <div class="col-md-6"><i class="fa-solid fa-eye me-1"></i><strong>Lượt xem: </strong> {{ $job->views }}
            </div>

            <div class="col-md-6">
                <i class="fa-solid fa-thumbtack me-1"></i><strong>Trạng thái:</strong> {!! $job->status_badge !!}
            </div>

            <div class="col-md-6">
                <i class="fa-brands fa-google me-1"></i><strong>Index Google: </strong>
                {!! $job->search_index ? '<span class="text-success">✔ Có</span>' : '<span class="text-danger">✖ Không</span>' !!}
            </div>

            <div class="col-md-6"><i class="fa-solid fa-star me-1"></i><strong>Nổi bật: </strong>
                {!! $job->featured_badge !!}</div>

            <div class="col-md-6"><i class="fa-solid fa-tag me-1"></i><strong>Meta title: </strong>
                {{ $job->meta_title ?? '-' }}</div>
            <div class="col-md-6"><i class="fa-solid fa-quote-left me-1"></i><strong>Meta description: </strong>
                {{ $job->meta_description ?? '-' }}</div>
        </div>

        <hr class="my-4">

        <div class="mb-3">
            <h6 class="fw-bold"><i class="fa-solid fa-file-lines me-1"></i>Mô tả công việc</h6>
            <p class="white-space-pre-line">{!! $job->description !!}</p>
        </div>
        <hr>
        <div class="mb-3">
            <h6 class="fw-bold"><i class="fa-solid fa-thumbtack me-1"></i>Yêu cầu công việc</h6>
            <p class="white-space-pre-line">{{ $job->requirements }}</p>
        </div>
        <hr>
        @if (is_array($job->benefits) || is_string($job->benefits))
            <div class="mb-3">
                <h6 class="fw-bold">🎁 Quyền lợi</h6>
                <ul class="ps-3">
                    @foreach (is_array($job->benefits) ? $job->benefits : json_decode($job->benefits, true) as $benefit)
                        <li>{{ $benefit }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (!empty($job->benefits))
    <div class="mb-3">
        <h6 class="fw-bold"><i class="fa-solid fa-gift me-1"></i>Quyền lợi</h6>
        <ul class="ps-3">
            @foreach (is_array($job->benefits) ? $job->benefits : (json_decode($job->benefits, true) ?? []) as $benefit)
                <li>{{ $benefit }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <hr>
        <div class="mb-2">
            <h6 class="fw-bold"><i class="fa-solid fa-screwdriver-wrench me-1"></i>Kỹ năng</h6>
            @forelse ($job->skills as $skill)
                <span class="badge bg-primary me-1">{{ $skill->name }}{{ $skill->pivot->required ? ' (*)' : '' }}</span>
            @empty
                <span class="text-muted">Không có kỹ năng</span>
            @endforelse
        </div>

        <div class="text-end text-muted small mt-3">
            <i class="fa-solid fa-clock me-1"></i>Ngày tạo: {{ $job->created_at->format('d/m/Y H:i') }}
        </div>
    </div>
</div>