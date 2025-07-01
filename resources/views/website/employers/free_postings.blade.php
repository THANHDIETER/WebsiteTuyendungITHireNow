@extends('website.layouts.master')
@section('content')
<main class="main-content">
    <section class="employers-details-area">
        <div class="container">
            <h2 class="mb-4">Employer Free Postings</h2>
            <table class="table table-striped">
                <thead>
                    <tr><th>ID</th><th>Company</th><th>Limit</th><th>Used</th><th>Reset At</th></tr>
                </thead>
                <tbody>
                    @foreach($frees as $free)
                    <tr>
                        <td>{{ $free->id }}</td>
                        <td>{{ $free->company->name }}</td>
                        <td>{{ $free->post_limit }}</td>
                        <td>{{ $free->post_used }}</td>
                        <td>{{ $free->reset_at? \Carbon\Carbon::parse($free->reset_at)->format('d/m/Y') : 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $frees->links() }}
        </div>
    </section>
</main>
@endsection
