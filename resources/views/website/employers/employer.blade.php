@extends('website.layouts.master')

@section('content')
<main class="main-content">
    <section class="container py-5">
        <h2 class="mb-4">Employer Dashboard</h2>
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ route('employers.subscriptions') }}">Company Package Subscriptions</a></li>
            <li class="list-group-item"><a href="{{ route('employers.orders') }}">Employer Package Orders</a></li>
            <li class="list-group-item"><a href="{{ route('employers.logs') }}">Employer Package Logs</a></li>
            <li class="list-group-item"><a href="{{ route('employers.free-postings') }}">Employer Free Postings</a></li>
            <li class="list-group-item"><a href="{{ route('employers.usages') }}">Employer Package Usages</a></li>
        </ul>
    </section>
</main>
@endsection