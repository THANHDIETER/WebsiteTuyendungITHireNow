<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {

        $blogs = Blog::latest()->paginate(6);
        $categories = \App\Models\Category::all(); // ✅ thêm dòng này để lấy danh sách categories
        $jobs = \App\Models\Job::latest()->paginate(6); // ✅ thêm dòng này để lấy danh sách jobs nếu cần
        return view('website.index', compact('blogs', 'categories', 'jobs')); // ✅ sửa đúng: blogs, categories
    }


    public function indexGrid()
    {
        $blogs = Blog::latest()->paginate(6);
        return view('website.blog.blog-grid', compact('blogs')); // ✅ sửa đúng: blogs
    }

    public function indexRightSidebar()
    {
        $blogs = Blog::latest()->paginate(6);
        return view('website.blog.blog-right-sidebar', compact('blogs')); // ✅ sửa đúng: blogs
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('website.blog.blog-details', compact('blog')); // ✅ đúng biến
    }
}
