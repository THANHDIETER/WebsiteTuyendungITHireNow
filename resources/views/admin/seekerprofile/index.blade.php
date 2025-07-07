@extends('admin.layouts.default')

@section('content')
<div class="container-fluid py-4">
    <h2 class="h4 mb-4">Danh sách ứng tuyển</h2>
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Ứng viên</th>
                        <th>Email</th>
                        <th>Công ty</th>
                        <th>Vị trí ứng tuyển</th>
                        <th>CV</th>
                        <th>Thư xin việc</th>
                        <th>Ngày ứng tuyển</th>
                        <th>Trạng thái</th>
                        <th>Shortlist</th>
                        <th>Ghi chú</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $app)
                        <tr>
                            <td>{{ $app->id }}</td>
                            <td>{{ $app->user?->name ?? '-' }}</td>
                            <td>{{ $app->user?->email ?? '-' }}</td>
                            <td>{{ $app->company?->name ?? '-' }}</td>
                            <td>{{ $app->job?->title ?? '-' }}</td>
                            <td>
                                @if($app->cv_url)
                                    <a href="{{ asset('storage/' . ltrim($app->cv_url, '/admin/')) }}" target="_blank">Xem CV</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ Str::limit($app->cover_letter, 20) }}</td>
                            <td>{{ $app->applied_at?->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $app->status }}</td>
                            <td>{!! $app->is_shortlisted ? '<span class="badge bg-success">✔</span>' : '-' !!}</td>
                            <td>{{ $app->note }}</td>
                            <td>
                                <button type="button" class="btn btn-secondary btn-sm btn-view" data-id="{{ $app->id }}" data-cv="{{ asset('storage/' . ltrim($app->cv_url, '/admin/')) }}" data-cover="{{ $app->cover_letter }}" data-status="{{ $app->status }}" data-note="{{ $app->note }}" data-user="{{ $app->user?->name }}" data-email="{{ $app->user?->email }}" data-job="{{ $app->job?->title }}" data-company="{{ $app->company?->name }}" data-applied="{{ $app->applied_at?->format('d/m/Y') }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted py-3">Không có ứng viên nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection