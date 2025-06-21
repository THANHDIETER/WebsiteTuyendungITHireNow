



@extends('website.layouts.master')

@section('content')
<style>
    .blog-item {
        margin-bottom: 30px;
        padding: 15px;
        border: 1px solid #eee;
        border-radius: 8px;
        background-color: #fff;
        transition: box-shadow 0.3s ease;
    }

    .blog-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .blog-item h3 {
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: #333;
    }

    .blog-item img {
        width: 100%;
        max-height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .blog-item p {
        font-size: 0.95rem;
        color: #555;
    }

    .blog-item a {
        color: #0c7b93;
        font-weight: 500;
        text-decoration: none;
    }

    .sidebar {
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        margin-top: 10px;
    }

    .sidebar h4 {
        margin-bottom: 15px;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .pagination {
        margin-top: 20px;
    }
</style>

<div class="row">
    <div class="col-md-8">
