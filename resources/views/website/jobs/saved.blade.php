{{-- @extends('website.layouts.master')

@section('content')
<main class="main-content">
  <div class="container py-5">
    <h2>Việc đã lưu</h2>
    @if($jobs->isEmpty())
      <p>Bạn chưa lưu công việc nào.</p>
    @else
      <div class="row">
        @foreach($jobs as $job)
          <div class="col-md-6 col-lg-4">
            <div class="recent-job-item">
              <h3 class="title">
                <a href="{{ route('jobs.show', $job) }}">{{ $job->title }}</a>
              </h3>
              <p>{{ $job->company_name ?? '—' }} • {{ $job->location ?? '—' }}</p>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</main>
@endsection --}}
