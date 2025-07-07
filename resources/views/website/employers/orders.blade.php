@extends('website.layouts.master')
@section('content')
<main class="main-content">
    <section class="employers-details-area">
        <div class="container">
            <h2 class="mb-4">Employer Package Orders</h2>
            <table class="table table-striped">
                <thead>
                    <tr><th>ID</th><th>Company</th><th>Package</th><th>Limit</th><th>Used</th><th>Start</th><th>End</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->company->name }}</td>
                        <td>{{ $order->package->name }}</td>
                        <td>{{ $order->post_limit }}</td>
                        <td>{{ $order->post_used }}</td>
                        <td>{{ $order->start_date ? \Carbon\Carbon::parse($order->start_date)->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ $order->end_date ? \Carbon\Carbon::parse($order->end_date)->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>
    </section>
</main>
@endsection
