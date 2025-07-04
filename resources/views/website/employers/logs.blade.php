@extends('website.layouts.master')
@section('content')
<main class="main-content">
    <section class="employers-details-area">
        <div class="container">
            <h2 class="mb-4">Employer Package Logs</h2>
            <table class="table table-striped">
                <thead>
                    <tr><th>ID</th><th>Order</th><th>Job</th><th>Action</th><th>Used At</th></tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->order->id }}</td>
                        <td>{{ $log->job?->title ?? '-' }}</td>
                        <td>{{ ucfirst(str_replace('_',' ',$log->action)) }}</td>
                        <td>{{ \Carbon\Carbon::parse($log->used_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $logs->links() }}
        </div>
    </section>
</main>
@endsection
