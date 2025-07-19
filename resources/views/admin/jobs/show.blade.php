<div class="container">
    <h2 class="h5 fw-bold text-primary mb-4">
        <i class="fa-solid fa-file-lines me-1"></i>Chi tiết tin tuyển dụng #{{ $job->id }}
    </h2>

    <div class="card shadow-sm border-0 p-4 rounded-4">
        <div class="row gy-3 gx-4">
            <div class="col-md-6"><i class="fa-solid fa-pen me-1"></i><strong>Tiêu đề:</strong> {{ $job->title }}</div>
            <div class="col-md-6"><i class="fa-solid fa-building me-1"></i><strong>Công ty:</strong>
                {{ $job->company->name ?? '-' }}</div>
            <div class="col-md-6"><i class="fa-solid fa-folder-open me-1"></i><strong>Danh mục:</strong>
                {{ $job->categories->isNotEmpty() ? $job->categories->pluck('name')->join(', ') : '-' }}</div>
            <div class="col-md-6"><i class="fa-solid fa-briefcase me-1"></i><strong>Hình thức:</strong>
                {{ $job->jobType?->name ?? '-' }}</div>
            <div class="col-md-6"><i class="fa-solid fa-house me-1"></i><strong>Địa chỉ:</strong>
                {{ $job->address ?? '-' }}</div>
            <div class="col-md-6"><i class="fa-solid fa-globe me-1"></i><strong>Remote:</strong>
                {{ $job->remotePolicy?->name ?? '-' }}</div>
            <div class="col-md-6"><i class="fa-solid fa-language me-1"></i><strong>Ngôn ngữ:</strong>
                {{ $job->language?->name ?? '-' }}</div>
            <div class="col-md-6"><i class="fa-solid fa-chart-line me-1"></i><strong>Kinh nghiệm:</strong>
                {{ $job->experience?->name ?? '-' }}</div>
            <div class="col-md-6"><i class="fa-solid fa-bullseye me-1"></i><strong>Cấp bậc:</strong>
                {{ $job->level?->name ?? '-' }}</div>
            <div class="col-md-6"><i class="fa-solid fa-money-bill-wave me-1"></i><strong>Mức lương:</strong>
                {{ $job->salary_range }}</div>
            <div class="col-md-6"><i class="fa-solid fa-calendar-day me-1"></i><strong>Hạn nộp:</strong>
                {{ optional($job->deadline)?->format('d/m/Y') ?? '-' }}</div>
            <div class="col-md-6"><i class="fa-solid fa-eye me-1"></i><strong>Lượt xem:</strong> {{ $job->views ?? 0 }}
            </div>
            <div class="col-md-6"><i class="fa-solid fa-thumbtack me-1"></i><strong>Trạng thái:</strong>
                {!! $job->status_badge !!}</div>
            <div class="col-md-6"><i class="fa-brands fa-google me-1"></i><strong>Index Google:</strong>
                {!! $job->search_index ? '<span class="text-success">✔ Có</span>' : '<span class="text-danger">✖ Không</span>' !!}
            </div>
            <div class="col-md-6"><i class="fa-solid fa-star me-1"></i><strong>Nổi bật:</strong>
                {!! $job->featured_badge !!}</div>
            <div class="col-md-6"><i class="fa-solid fa-tag me-1"></i><strong>Meta title:</strong>
                {{ $job->meta_title ?? '-' }}</div>
            <div class="col-md-6"><i class="fa-solid fa-quote-left me-1"></i><strong>Meta description:</strong>
                {{ $job->meta_description ?? '-' }}</div>
        </div>

        <hr class="my-4">

        <div class="mb-4">
            <h6 class="fw-bold mb-2"><i class="fa-solid fa-file-lines me-1"></i>Mô tả công việc</h6>
            <div class="job-content">{!! $job->description !!}</div>
        </div>

        <hr>

        <div class="mb-4">
            <h6 class="fw-bold mb-2"><i class="fa-solid fa-thumbtack me-1"></i>Yêu cầu công việc</h6>
            <div class="job-content">{!! $job->requirements !!}</div>
        </div>

        @if (!empty($job->benefits))
            @php
                $benefits = is_array($job->benefits)
                    ? $job->benefits
                    : preg_split('/\r\n|\r|\n/', $job->benefits);
            @endphp

            @if (!empty($benefits))
                <hr>
                <div class="mb-4">
                    <h6 class="fw-bold mb-2"><i class="fa-solid fa-gift me-1"></i>Phúc lợi</h6>
                    <ul class="ps-3 mb-0">
                        @foreach ($benefits as $benefit)
                            @if (!empty(trim($benefit)))
                                <li>{{ $benefit }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif


        <hr>

        <div class="mb-4">
            <h6 class="fw-bold mb-2"><i class="fa-solid fa-screwdriver-wrench me-1"></i>Kỹ năng</h6>
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