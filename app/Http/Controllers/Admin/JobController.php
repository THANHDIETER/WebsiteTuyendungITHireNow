<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with(['company', 'category', 'skills'])
                    ->where('is_approved', false);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $jobs = $query->orderByDesc('created_at')->paginate(10);

        return view('admin.jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        $job->load(['company', 'category', 'skills']);
        return view('admin.jobs.show', compact('job'));
    }

    public function approve(Request $request, Job $job)
    {
        $job->is_approved = true;
        $job->save();

        return redirect()->route('admin.jobs.index')->with('success', 'Tin tuyển dụng đã được duyệt.');
    }

    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()->route('admin.jobs.index')->with('success', 'Tin tuyển dụng đã bị xoá.');
    }
}
