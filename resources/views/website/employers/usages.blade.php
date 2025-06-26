@extends('website.layouts.master')
@section('content')
<main class="main-content">
    <section class="employers-details-area">
        <div class="container">
            <h2 class="mb-4">Employer Package Usages</h2>
            <table class="table table-striped">
                <thead>
                    <tr><th>ID</th><th>Company</th><th>Package</th><th>Limit</th><th>Used</th><th>Active</th><th>Start</th><th>End</th></tr>
                </thead>
                <tbody>
                    @foreach($usages as $usage)
                    <tr>
                        <td>{{ $usage->id }}</td>
                        <td>{{ $usage->company->name }}</td>
                        <td>{{ $usage->package->name }}</td>
                        <td>{{ $usage->post_limit }}</td>
                        <td>{{ $usage->posts_used }}</td>
                        <td>{{ $usage->is_active? 'Yes':'No' }}</td>
                        <td>{{ \Carbon\Carbon::parse($usage->start_date)->format('d/m/Y H:i') }}</td>
                        <td>{{ $usage->end_date? \Carbon\Carbon::parse($usage->end_date)->format('d/m/Y H:i') : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $usages->links() }}
        </div>
    </section>
</main>
@endsection