@extends('website.layouts.master')

@section('content')
<main class="main-content">
    <section class="employers-details-area">
        <div class="container">
            <h2 class="mb-4">Company Package Subscriptions</h2>
            <table class="table table-striped">
                <thead>
                    <tr><th>ID</th><th>Company</th><th>Package</th><th>Start</th><th>End</th><th>Remaining</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $sub)
                    <tr>
                        <td>{{ $sub->id }}</td>
                        <td>{{ $sub->company->name }}</td>
                        <td>{{ $sub->package->name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($sub->start_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($sub->end_date)->format('d/m/Y') }}</td>
                        <td>{{ $sub->remaining_posts }}</td>
                        <td>{{ $sub->is_active ? 'Active' : 'Inactive' }}</td>
                        <td><a href="{{ route('employers.subscriptions.edit', $sub) }}" class="btn btn-sm btn-warning">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $subscriptions->links() }}
        </div>
    </section>
</main>
@endsection
