@extends('website.layouts.master')

@section('content')
<div class="page-header-area d-flex justify-content-center align-items-center text-center"
    data-bg-img="{{ asset('client/assets/img/banner/15.png') }}"
    style="max-height: 80px; height: 80px; padding: 0 !important;">
    &nbsp;
</div>

<main class="main-content container py-4 py-md-5">
    @php
    use Illuminate\Support\Str;

    // Logic remains unchanged
    $view = in_array(request('view'), ['grid','list']) ? request('view') : 'grid';
    $sortDefault = request('sort', request('q') ? 'relevance' : 'newest');
    $perPage = (int) request('per_page', 9);

    $sym = ['VND'=>'₫','VNĐ'=>'₫','USD'=>'$','EUR'=>'€','JPY'=>'¥','KRW'=>'₩','GBP'=>'£','AUD'=>'A$','CAD'=>'C$','SGD'=>'S$','THB'=>'฿'];

    $abbr = function(int $v, string $cur) {
    $uc = strtoupper($cur);
    if (in_array($uc, ['VND','VNĐ'])) {
    if ($v >= 1_000_000) return rtrim(number_format($v/1_000_000, 0), '0').'tr';
    if ($v >= 1_000) return rtrim(number_format($v/1_000, 0), '0').'k';
    return number_format($v);
    }
    if ($v >= 1_000_000) return rtrim(number_format($v/1_000_000, 1), '0').'m';
    if ($v >= 1_000) return rtrim(number_format($v/1_000, 1), '0').'k';
    return number_format($v);
    };

    $formatSalary = function($job) use ($sym, $abbr) {
    $cur = trim($job->currency ?? 'VND');
    $min = (int)($job->salary_min ?? 0);
    $max = (int)($job->salary_max ?? 0);
    $sign = $sym[strtoupper($cur)] ?? $cur;

    if (!$min && !$max) return 'Thỏa thuận';
    $left = $sign.$abbr($min, $cur);
    $right = $max ? $sign.$abbr($max, $cur) : '∞';
    return "{$left} - {$right}/tháng";
    };
    @endphp

    {{-- ===================== --}}
    {{-- SEARCH FILTER SECTION --}}
    {{-- ===================== --}}
    <div class="search-section mb-5">
        <form action="{{ route('jobs.search') }}" method="GET" class="search-wrap card border-2 border-primary shadow-sm rounded-4 p-4 animate__animated animate__fadeIn">
            @foreach(request()->except(['page']) as $k => $v)
            @if(is_array($v))
            @foreach($v as $vv) <input type="hidden" name="{{ $k }}[]" value="{{ $vv }}"> @endforeach
            @else
            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
            @endif
            @endforeach

            {{-- Quick Search Section --}}
            <div class="quick-search-section filter-section">
                <h6 class="section-title mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-search text-primary"></i> Bộ lọc thường
                </h6>
                <hr><br>
                <div class="row g-3 align-items-end quick-row">
                    <div class="col-12 col-md-5">
                        <label class="form-label fw-semibold small mb-2 d-flex align-items-center gap-2">
                            <i class="bi bi-search text-primary"></i> Từ khóa
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-end-0"></span>
                            <input type="text" name="q" value="{{ request('q') }}"
                                class="form-control border-start-0 rounded-end-pill"
                                placeholder="Từ khóa tìm kiếm">
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold small mb-2 d-flex align-items-center gap-2">
                            <i class="bi bi-geo-alt text-primary"></i> Địa điểm
                        </label>
                        <select class="form-select rounded-pill" name="location_id">
                            <option value="">Tất cả</option>
                            @foreach($locations as $i)
                            <option value="{{ $i->id }}" @selected(request('location_id')==$i->id)>{{ $i->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-3 d-grid">
                        <button class="btn btn-primary rounded-pill px-4" type="submit">
                            <i class="bi bi-search me-2"></i>Tìm kiếm
                        </button>
                    </div>
                </div>
            </div>

            <div class="section-divider mt-4"></div>

            {{-- Utility Bar: Sort, Per Page, View, and Advanced Filters Toggle --}}
            <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between mt-4">
                <div class="d-flex gap-2 align-items-center">
                    <div class="d-flex gap-2">
                        <select name="sort" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                            <option value="newest" @selected($sortDefault==='newest' )>Mới nhất</option>
                            <option value="relevance" @selected($sortDefault==='relevance' )>Độ liên quan</option>
                            <option value="salary" @selected($sortDefault==='salary' )>Lương cao</option>
                            <option value="views" @selected($sortDefault==='views' )>Xem nhiều</option>
                        </select>
                        <select name="per_page" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                            @foreach([6,9,12,15,24,30,50] as $pp)
                            <option value="{{ $pp }}" @selected($perPage===$pp)>{{ $pp }}/trang</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="btn-group" role="group" aria-label="View switch">
                        <input type="radio" class="btn-check" name="view" id="v_grid" value="grid" @checked($view==='grid' ) onchange="this.form.submit()">
                        <label class="btn btn-sm btn-outline-secondary rounded-pill" for="v_grid"><i class="bi bi-grid"></i> Lưới</label>
                        <input type="radio" class="btn-check" name="view" id="v_list" value="list" @checked($view==='list' ) onchange="this.form.submit()">
                        <label class="btn btn-sm btn-outline-secondary rounded-pill" for="v_list"><i class="bi bi-list"></i> Danh sách</label>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a class="btn btn-outline-secondary btn-sm rounded-pill px-3"
                        href="{{ route('jobs.search') }}"><i class="bi bi-x-lg me-2"></i>Xóa tất cả</a>
                    <button class="btn btn-light btn-sm rounded-pill px-3 filter-toggle" type="button"
                        data-bs-toggle="collapse" data-bs-target="#advancedFilters" aria-expanded="{{ request()->hasAny([
                                'category_id','remote_policy_id','company_id','level_id','experience_id','language_id','currency','min_salary','max_salary','skills','skills_mode','is_featured','job_type_id'
                            ]) ? 'true' : 'false' }}">
                        <i class="bi bi-funnel me-2"></i>Bộ lọc nâng cao
                    </button>
                </div>
            </div>

            <div class="section-divider mt-4"></div>

            {{-- Advanced Filters (Collapse) --}}
            <div id="advancedFilters" class="collapse mt-4 {{ request()->hasAny([
                'category_id','remote_policy_id','company_id','level_id','experience_id','language_id','currency','min_salary','max_salary','skills','skills_mode','is_featured','job_type_id'
            ]) ? 'show' : '' }}">
                <h6 class="section-title mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-funnel-fill text-primary"></i> Bộ lọc nâng cao
                </h6>
                <hr>
                <div class="filter-adv row g-3">
                    <div class="col-12 filter-section">
                        <div class="filter-header">
                            <label class="form-label fw-semibold mb-2 d-flex align-items-center gap-2">
                                <i class="bi bi-briefcase-fill text-primary"></i> Ngành nghề
                            </label>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            @php $cat = (string) request('category_id'); @endphp
                            <input class="btn-check" type="radio" name="category_id" id="cat_all" value="" @checked($cat==='' )>
                            <label class="pill" for="cat_all">Tất cả</label>
                            @foreach($categories as $c)
                            @php $cid = (string) $c->id; @endphp
                            <input class="btn-check" type="radio" name="category_id" id="cat_{{ $cid }}" value="{{ $cid }}" @checked($cat===$cid)>
                            <label class="pill" for="cat_{{ $cid }}">{{ $c->name }}</label>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 filter-divider"></div>

                    <div class="col-12 col-md-6 filter-section">
                        <div class="filter-header">
                            <label class="form-label fw-semibold mb██

                            mb-2 d-flex align-items-center gap-2">
                                <i class="bi bi-person-workspace text-primary"></i> Hình thức
                            </label>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            @php $rp = (string) request('remote_policy_id'); @endphp
                            <input class="btn-check" type="radio" name="remote_policy_id" id="rp_all" value="" @checked($rp==='' )>
                            <label class="pill" for="rp_all">Tất cả</label>
                            <input class="btn-check" type="radio" name="remote_policy_id" id="rp_1" value="1" @checked($rp==='1' )>
                            <label class="pill" for="rp_1">Onsite</label>
                            <input class="btn-check" type="radio" name="remote_policy_id" id="rp_2" value="2" @checked($rp==='2' )>
                            <label class="pill" for="rp_2">Remote</label>
                            <input class="btn-check" type="radio" name="remote_policy_id" id="rp_3" value="3" @checked($rp==='3' )>
                            <label class="pill" for="rp_3">Hybrid</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 filter-section">
                        <div class="filter-header">
                            <label class="form-label fw-semibold mb-2 d-flex align-items-center gap-2">
                                <i class="bi bi-briefcase text-primary"></i> Loại việc
                            </label>
                        </div>
                        <select class="form-select rounded-pill" name="job_type_id">
                            <option value="">Tất cả</option>
                            @php $jt = (string) request('job_type_id'); @endphp
                            @foreach($jobTypes as $t)
                            @php $tid = (string) $t->id; @endphp
                            <option value="{{ $tid }}" @selected($jt===$tid)>{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 filter-divider"></div>

                    <div class="col-12 col-md-6 filter-section">
                        <div class="filter-header">
                            <label class="form-label fw-semibold mb-2 d-flex align-items-center gap-2">
                                <i class="bi bi-building text-primary"></i> Công ty
                            </label>
                        </div>
                        <select class="form-select rounded-pill" name="company_id">
                            <option value="">Tất cả</option>
                            @foreach($companies as $co)
                            <option value="{{ $co->id }}" @selected(request('company_id')==$co->id)>{{ $co->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6 filter-section">
                        <div class="filter-header">
                            <label class="form-label fw-semibold mb-2 d-flex align-items-center gap-2">
                                <i class="bi bi-currency-dollar text-primary"></i> Đơn vị tiền tệ
                            </label>
                        </div>
                        <select class="form-select rounded-pill" name="currency">
                            <option value="">Tất cả</option>
                            @php $curSel = (string) request('currency'); @endphp
                            @foreach($currencies as $c)
                            <option value="{{ $c }}" @selected($curSel===$c)>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 filter-divider"></div>

                    <div class="col-12 col-md-4 filter-section">
                        <div class="filter-header">
                            <label class="form-label fw-semibold mb-2 d-flex align-items-center gap-2">
                                <i class="bi bi-award text-primary"></i> Cấp bậc
                            </label>
                        </div>
                        <select class="form-select rounded-pill" name="level_id">
                            <option value="">Tất cả</option>
                            @foreach($levels as $lv)
                            <option value="{{ $lv->id }}" @selected(request('level_id')==$lv->id)>{{ $lv->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-4 filter-section">
                        <div class="filter-header">
                            <label class="form-label fw-semibold mb-2 d-flex align-items-center gap-2">
                                <i class="bi bi-briefcase-fill text-primary"></i> Kinh nghiệm
                            </label>
                        </div>
                        <select class="form-select rounded-pill" name="experience_id">
                            <option value="">Tất cả</option>
                            @foreach($experiences as $ex)
                            <option value="{{ $ex->id }}" @selected(request('experience_id')==$ex->id)>{{ $ex->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-4 filter-section">
                        <div class="filter-header">
                            <label class="form-label fw-semibold mb-2 d-flex align-items-center gap-2">
                                <i class="bi bi-translate text-primary"></i> Ngôn ngữ
                            </label>
                        </div>
                        <select class="form-select rounded-pill" name="language_id">
                            <option value="">Tất cả</option>
                            @foreach($languages as $lang)
                            <option value="{{ $lang->id }}" @selected(request('language_id')==$lang->id)>{{ $lang->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 filter-divider"></div>

                    <div class="col-12 filter-section">
                        <div class="filter-header">
                            <label class="form-label fw-semibold mb-2 d-flex align-items-center gap-2">
                                <i class="bi bi-wallet2 text-primary"></i> Mức lương & Ưu tiên
                            </label>
                        </div>
                        <div class="d-flex align-items-center gap-3 salary-filter-wrap">
                            <input type="number" class="form-control form-control-sm rounded-pill" name="min_salary" placeholder="Từ" value="{{ request('min_salary') }}">
                            <span class="text-muted">—</span>
                            <input type="number" class="form-control form-control-sm rounded-pill" name="max_salary" placeholder="Đến" value="{{ request('max_salary') }}">
                            <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" type="button"
                                onclick="this.form.min_salary.value='';this.form.max_salary.value=''">
                                <i class="bi bi-x-lg"></i>
                            </button>
                            <div class="form-check form-switch ms-auto">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" @checked(request('is_featured'))>
                                <label class="form-check-label" for="is_featured"><i class="bi bi-star-fill text-primary me-2"></i>Ưu tiên Nổi bật</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 filter-divider"></div>

                    <div class="col-12 filter-section">
                        <div class="filter-header">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="form-label fw-semibold mb-0 d-flex align-items-center gap-2">
                                    <i class="bi bi-tools text-primary"></i> Kỹ năng
                                </label>
                                <select name="skills_mode" class="form-select form-select-sm rounded-pill w-auto">
                                    <option value="any" {{ request('skills_mode','any')==='any' ? 'selected' : '' }}>Khớp 1 trong số</option>
                                    <option value="all" {{ request('skills_mode')==='all' ? 'selected' : '' }}>Khớp tất cả</option>
                                </select>
                            </div>
                        </div>
                        <div class="skills-chip-wrap">
                            <input type="checkbox" class="btn-check" id="sk_clear"
                                onclick="[...document.querySelectorAll('[name=\'skills[]\']')].forEach(i=>i.checked=false); this.checked=false;">
                            <label class="chip-check chip-clear" for="sk_clear">Bỏ chọn tất cả</label>
                            @php $selSkills = collect(request('skills', []))->map(fn($v)=>(string)$v)->toArray(); @endphp
                            @foreach($skills as $s)
                            @php $id = (string)$s->id; $label = $s->skill_name ?? $s->name ?? $s->title ?? ('#'.$id); @endphp
                            <input class="btn-check" type="checkbox" name="skills[]" id="sk_{{ $id }}" value="{{ $id }}" @checked(in_array($id,$selSkills))>
                            <label class="chip-check" for="sk_{{ $id }}">{{ $label }}</label>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                        <button class="btn btn-light rounded-pill px-4 filter-btn" type="button" data-bs-toggle="collapse" data-bs-target="#advancedFilters">
                            <i class="bi bi-x-lg me-2"></i>Đóng bộ lọc
                        </button>
                        <button class="btn btn-primary rounded-pill px-4 filter-btn" type="submit">
                            <i class="bi bi-search me-2"></i>Tìm kiếm
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Job Results Section --}}
    <div class="job-results-section">
        <section class="py-5">
            @if($view === 'grid')
            <div class="row g-5">
                @forelse($jobs as $job)
                <div class="col-md-6 col-lg-4">
                    <div class="job-card card border-2 border-success shadow-sm rounded-4 h-100 position-relative animate__animated animate__fadeInUp">
                        @if ($job->is_featured)
                        <span class="badge badge-top position-absolute top-0 start-0 m-2"><i class="bi bi-star-fill me-1"></i>TOP</span>
                        @endif
                        @if ($job->is_paid)
                        <span class="badge badge-hot position-absolute top-0 end-0 m-2"><i class="bi bi-fire me-1"></i>HOT</span>
                        @endif

                        <a href="{{ route('jobs.show', $job->slug) }}" class="d-block overflow-hidden rounded-top-4" style="height:180px;">
                            <img src="{{ $job->thumbnail ? asset('storage/'.$job->thumbnail) : asset('client/assets/img/default-thumbnail.jpg') }}"
                                alt="{{ $job->title }}" style="object-fit:cover;width:100%;height:100%;transition:transform 0.3s ease;"
                                class="job-card-img">
                        </a>

                        <div class="p-4">
                            <h5 class="job-title mb-2 fw-semibold">
                                <a class="text-dark text-decoration-none" href="{{ route('jobs.show', $job->slug) }}">{{ Str::limit($job->title, 50) }}</a>
                            </h5>

                            <div class="small text-muted mb-3 d-flex flex-wrap gap-2">
                                <span><i class="bi bi-building me-1"></i>{{ $job->company->name ?? 'N/A' }}</span>
                                @if($job->company && $job->location)<span class="text-muted">•</span>@endif
                                <span><i class="bi bi-geo-alt me-1"></i>{{ $job->location->name ?? 'N/A' }}</span>
                                @if($job->created_at)<span class="text-muted">•</span><span><i class="bi bi-clock me-1"></i>{{ $job->created_at->diffForHumans() }}</span>@endif
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="badge job-type-badge">{{ $job->jobType->name ?? 'N/A' }}</span>
                                <div class="salary-display">
                                    <span class="salary-text"><i class="bi bi-wallet2 me-1"></i>{{ $formatSalary($job) }}</span>
                                </div>
                            </div>

                            <div class="chips-scroll mb-3">
                                @php $show = $job->skills->take(8); $remain = max(0,$job->skills->count()-$show->count()); @endphp
                                @foreach($show as $sk)
                                <span class="chip-mini">{{ $sk->skill_name ?? $sk->name ?? $sk->title ?? ('#'.$sk->id) }}</span>
                                @endforeach
                                @if($remain>0)<span class="chip-mini more">+{{ $remain }}</span>@endif
                            </div>

                            <div class="d-flex justify-content-between gap-2">
                                <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-outline-primary btn-sm rounded-pill flex-fill">Xem chi tiết</a>
                                <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-primary btn-sm rounded-pill flex-fill">Ứng tuyển</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center py-4 animate__animated animate__fadeIn">
                        <h5><i class="bi bi-info-circle me-2"></i>Không tìm thấy việc làm phù hợp.</h5>
                    </div>
                </div>
                @endforelse
            </div>
            @else
            <div class="vstack gap-5">
                @forelse($jobs as $job)
                <div class="job-row card border-2 border-success shadow-sm rounded-4 p-4 animate__animated animate__fadeInUp">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm-3">
                            <a href="{{ route('jobs.show', $job->slug) }}" class="d-block rounded overflow-hidden" style="height:120px;">
                                <img src="{{ $job->thumbnail ? asset('storage/'.$job->thumbnail) : asset('client/assets/img/default-thumbnail.jpg') }}"
                                    alt="{{ $job->title }}" style="object-fit:cover;width:100%;height:100%;transition:transform 0.3s ease;"
                                    class="job-card-img">
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                @if($job->is_featured) <span class="badge badge-top"><i class="bi bi-star-fill me-1"></i>TOP</span> @endif
                                <!-- @if($job->is_paid) <span class="badge badge-hot"><i class="bi bi-fire me-1"></i>HOT</span> @endif -->
                            </div>
                            <h5 class="mb-2 fw-semibold"><a class="text-dark text-decoration-none" href="{{ route('jobs.show', $job->slug) }}">{{ Str::limit($job->title, 60) }}</a></h5>
                            <div class="small text-muted mb-3 d-flex flex-wrap gap-2">
                                <span><i class="bi bi-building me-1"></i>{{ $job->company->name ?? 'N/A' }}</span>
                                @if($job->company && $job->location)<span class="text-muted">•</span>@endif
                                <span><i class="bi bi-geo-alt me-1"></i>{{ $job->location->name ?? 'N/A' }}</span>
                                @if($job->jobType)<span class="text-muted">•</span><span><i class="bi bi-briefcase me-1"></i>{{ $job->jobType->name }}</span>@endif
                                @if($job->created_at)<span class="text-muted">•</span><span><i class="bi bi-clock me-1"></i>{{ $job->created_at->diffForHumans() }}</span>@endif
                            </div>
                            <div class="chips-scroll mb-3">
                                @php $show = $job->skills->take(12); $remain = max(0,$job->skills->count()-$show->count()); @endphp
                                @foreach($show as $sk)
                                <span class="chip-mini">{{ $sk->skill_name ?? $sk->name ?? $sk->title ?? ('#'.$sk->id) }}</span>
                                @endforeach
                                @if($remain>0)<span class="chip-mini more">+{{ $remain }}</span>@endif
                            </div>
                        </div>
                        <div class="col-sm-3 text-sm-end">
                            <div class="mb-3">
                                <div class="salary-display">
                                    <span class="salary-text"><i class="bi bi-wallet2 me-1"></i>{{ $formatSalary($job) }}</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Chi tiết</a>
                                <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-primary btn-sm rounded-pill px-3">Ứng tuyển</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-info text-center py-4 animate__animated animate__fadeIn">
                    <h5><i class="bi bi-info-circle me-2"></i>Không tìm thấy việc làm phù hợp.</h5>
                </div>
                @endforelse
            </div>
            @endif

            <div class="pagination-section mt-6 d-flex justify-content-center">
                {{ $jobs->appends(request()->except('page'))->links() }}
            </div>
        </section>
    </div>
</main>

{{-- Styles --}}
<style>
    .search-section,
    .job-results-section,
    .pagination-section {
        margin-bottom: 2rem;
    }

    .search-wrap {
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        border: 2px solid #2b6fdb !important;
        transition: all 0.3s ease;
    }

    .search-wrap:hover {
        box-shadow: 0 8px 24px rgba(43, 111, 219, 0.2);
    }

    /* Section Titles and Dividers */
    .section-title {
        font-size: 1.1rem;
        color: #2b6fdb;
        font-weight: 600;
        border-left: 4px solid #2b6fdb;
        padding-left: 1rem;
        transition: all 0.3s ease;
    }

    .section-title:hover {
        color: #1f5fd1;
        transform: translateX(4px);
    }

    .section-divider {
        height: 2px;
        background: linear-gradient(to right, transparent, #2b6fdb, transparent);
        margin: 1.5rem 0;
        opacity: 0.7;
    }

    /* Quick Search Row */
    .quick-row .form-control,
    .quick-row .form-select {
        height: 46px;
        border-radius: 50px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
    }

    .quick-row .form-control:focus,
    .quick-row .form-select:focus {
        border-color: #2b6fdb;
        box-shadow: 0 0 0 0.2rem rgba(43, 111, 219, 0.25);
        transform: scale(1.02);
    }

    .quick-row .input-group-text {
        background: #f8f9fa;
        border: 1px solid #ced4da;
        border-right: none;
        border-radius: 50px 0 0 50px;
    }

    .quick-row .form-control {
        border: 1px solid #ced4da;
        border-radius: 0 50px 50px 0;
    }

    .quick-row .btn {
        height: 46px;
        font-size: 0.95rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .quick-row .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(43, 111, 219, 0.3);
    }

    /* Advanced Filters */
    .filter-adv .form-select,
    .filter-adv .form-control {
        height: 42px;
        border-radius: 50px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
    }

    .filter-adv .form-select:focus,
    .filter-adv .form-control:focus {
        border-color: #2b6fdb;
        box-shadow: 0 0 0 0.2rem rgba(43, 111, 219, 0.25);
        transform: scale(1.02);
    }

    .filter-adv .form-control-sm {
        height: 38px;
        min-width: 100px;
    }

    .filter-adv .form-check {
        margin-top: 0;
        display: flex;
        align-items: center;
    }

    .salary-filter-wrap {
        flex-wrap: nowrap;
        background: #f8fbff;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .salary-filter-wrap:hover {
        background: #e9f2ff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .salary-filter-wrap .form-control-sm {
        flex: 1;
        min-width: 80px;
    }

    .salary-filter-wrap .btn {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        line-height: 1;
    }

    .salary-filter-wrap .text-muted {
        font-size: 0.9rem;
        flex: 0 0 auto;
    }

    .salary-filter-wrap .form-check-input {
        margin-top: 0;
    }

    .salary-filter-wrap .form-check-label {
        font-size: 0.9rem;
    }

    /* Filter Sections and Dividers */
    .filter-section {
        position: relative;
        padding: 1.5rem;
        background: #fff;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .filter-section:hover {
        background: #f8fbff;
        box-shadow: 0 4px 12px rgba(43, 111, 219, 0.1);
        transform: translateY(-2px);
    }

    .filter-divider {
        height: 2px;
        background: linear-gradient(to right, transparent, #2b6fdb, transparent);
        margin: 1.5rem 0;
        opacity: 0.7;
    }

    .filter-header {
        position: relative;
        padding-left: 1.5rem;
        transition: all 0.3s ease;
    }

    .filter-header::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 1.5rem;
        background: #2b6fdb;
        border-radius: 2px;
        transition: height 0.3s ease;
    }

    .filter-section:hover .filter-header::before {
        height: 2rem;
    }

    /* Pills */
    .pill {
        border: 1px solid #d7e3ff;
        background: #f8fbff;
        color: #2b6fdb;
        border-radius: 999px;
        padding: 0.5rem 1.2rem;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease, transform 0.2s ease;
        flex: 0 1 auto;
        white-space: nowrap;
    }

    .btn-check:checked+.pill {
        background: #2b6fdb;
        border-color: #2b6fdb;
        color: #fff;
        font-weight: 500;
        transform: scale(1.05);
    }

    .pill:hover {
        background: #e9f2ff;
        border-color: #9dc2ff;
        transform: scale(1.05);
    }

    /* Skill Chips */
    .skills-chip-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 0.5rem 0;
    }

    .chip-check {
        border: 1px solid #d7e3ff;
        background: #f8fbff;
        color: #2b6fdb;
        border-radius: 999px;
        padding: 0.5rem 1.2rem;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease, transform 0.2s ease;
        flex: 0 1 auto;
        white-space: nowrap;
    }

    .btn-check:checked+.chip-check {
        background: #2b6fdb;
        border-color: #2b6fdb;
        color: #fff;
        font-weight: 500;
        transform: scale(1.05);
    }

    .chip-check.chip-clear {
        border-style: dashed;
        color: #6b7280;
        background: #fff;
    }

    .chip-check:hover {
        background: #e9f2ff;
        border-color: #9dc2ff;
        transform: scale(1.05);
    }

    /* Filter Buttons */
    .filter-btn,
    .filter-toggle {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .filter-btn:hover,
    .filter-toggle:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(43, 111, 219, 0.3);
    }

    /* Job Cards and Rows */
    .chips-scroll {
        display: flex;
        gap: 0.5rem;
        overflow: auto hidden;
        white-space: nowrap;
        padding-bottom: 0.3rem;
    }

    .chip-mini {
        display: inline-flex;
        align-items: center;
        padding: 0.3rem 0.7rem;
        border-radius: 999px;
        background: #eef4ff;
        border: 1px solid #d7e3ff;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }

    .chip-mini:hover {
        background: #d7e3ff;
    }

    .chip-mini.more {
        background: #f6f6f6;
        border-color: #e4e4e4;
        color: #666;
    }

    .job-card,
    .job-row {
        background: #fff;
        border: 2px solid #28a745 !important;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .job-card:hover,
    .job-row:hover {
        box-shadow: 0 12px 30px rgba(40, 167, 69, 0.2);
        transform: translateY(-6px);
    }

    .job-card-img:hover {
        transform: scale(1.05);
    }

    .job-title a:hover {
        color: #2b6fdb;
    }

    .salary-display {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.4rem 1rem;
        border-radius: 999px;
        background: linear-gradient(135deg, #28a745 0%, #34c759 100%);
        border: 1px solid #1f7a33;
        color: #fff;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 3px 8px rgba(40, 167, 69, 0.2);
        transition: all 0.2s ease, transform 0.2s ease;
    }

    .salary-display:hover {
        background: linear-gradient(135deg, #23963d 0%, #2db74f 100%);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        transform: scale(1.05);
    }

    .salary-text {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .job-type-badge {
        background: #e9f2ff;
        color: #2b6fdb;
        font-weight: 600;
        border-radius: 999px;
        padding: 0.3rem 0.8rem;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }

    .job-type-badge:hover {
        background: #d7e3ff;
    }

    .badge-hot {
        background: linear-gradient(90deg, #ff7e00, #ff3d00);
        color: #fff;
        font-weight: 600;
        border-radius: 999px;
        padding: 5px 14px;
        font-size: 0.8rem;
        box-shadow: 0 0 12px rgba(255, 100, 0, 0.5);
        transition: all 0.2s ease;
    }

    .badge-top {
        background: #28a745;
        color: #fff;
        font-weight: 600;
        border-radius: 999px;
        padding: 5px 14px;
        font-size: 0.8rem;
        box-shadow: 0 0 8px rgba(40, 167, 69, 0.4);
        transition: all 0.2s ease;
    }

    .badge-hot:hover,
    .badge-top:hover {
        opacity: 0.9;
    }

    /* Buttons */
    .btn-primary {
        background: #2b6fdb;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #1f5fd1;
        box-shadow: 0 4px 12px rgba(43, 111, 219, 0.3);
    }

    .btn-outline-primary {
        border-color: #2b6fdb;
        color: #2b6fdb;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: #e9f2ff;
        border-color: #1f5fd1;
        color: #1f5fd1;
    }

    .btn-outline-secondary {
        border-color: #6b7280;
        color: #6b7280;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background: #f8f9fa;
        border-color: #2b6fdb;
        color: #2b6fdb;
    }

    .btn-light {
        border-color: #e9ecef;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .btn-light:hover {
        background: #e9ecef;
        border-color: #d7e3ff;
        color: #2b6fdb;
    }

    /* Mobile Responsiveness */
    @media (max-width: 576px) {

        .search-section,
        .job-results-section,
        .pagination-section {
            margin-bottom: 1.5rem;
        }

        .quick-row .form-control,
        .quick-row .form-select,
        .quick-row .btn {
            height: 40px;
            font-size: 0.9rem;
        }

        .quick-row .input-group-text {
            border-radius: 12px 0 0 12px;
        }

        .quick-row .form-control {
            border-radius: 0 12px 12px 0;
        }

        .filter-adv .form-select,
        .filter-adv .form-control {
            height: 38px;
        }

        .filter-adv .form-control-sm {
            height: 34px;
            min-width: 80px;
        }

        .salary-filter-wrap {
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 0.75rem;
        }

        .salary-filter-wrap .form-check {
            width: 100%;
        }

        .pill,
        .chip-check {
            padding: 0.4rem 1rem;
            font-size: 0.85rem;
        }

        .section-divider,
        .filter-divider {
            margin: 1rem 0;
            height: 1px;
        }

        .section-title {
            font-size: 1rem;
        }

        .filter-section {
            padding: 1rem;
        }

        .filter-header::before {
            height: 1.2rem;
        }

        .filter-section:hover .filter-header::before {
            height: 1.5rem;
        }

        .job-card,
        .job-row {
            padding: 1rem !important;
        }

        .job-title {
            font-size: 1.1rem;
        }

        .job-card-img {
            height: 140px !important;
        }

        .salary-display {
            font-size: 0.85rem;
            padding: 0.3rem 0.8rem;
        }

        .row.g-5 {
            --bs-gutter-x: 1.5rem;
        }

        .vstack.gap-5 {
            --bs-gutter-y: 1.5rem;
        }
    }
</style>
@endsection