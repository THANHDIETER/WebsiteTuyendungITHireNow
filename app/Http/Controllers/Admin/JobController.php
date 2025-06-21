<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\Employer\JobApprovedNotification;
use App\Notifications\Employer\JobRejectedNotification;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with(['company', 'category', 'skills']);

        if ($request->has('is_approved')) {
            $query->where('is_approved', $request->is_approved);
        } else {
            $query->where('is_approved', false);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('id', 'like', '%' . $request->search . '%');
        }

        $jobs = $query->orderByDesc('id')->paginate(10);
        $categories = Category::orderBy('name')->get();

        return view('admin.jobs.index', compact('jobs', 'categories'));
    }

    public function show(Job $job)
    {
        return view('admin.jobs.show', compact('job'));
    }

    public function approve(Request $request, Job $job)
    {
        if ($job->status !== 'pending') {
            $job->refresh(); // Đảm bảo trạng thái là mới nhất từ DB

            return response()->json([
                'success' => false,
                'message' => 'Tin đã được xử lý bởi người khác.',
                'status_html' => $job->status_badge,
            ], 409);
        }

        // Cập nhật trạng thái
        $job->update(['status' => 'published']);

        // Gửi notification cho nhà tuyển dụng
        $employer = $job->company->user;
        $employer->notify(new JobApprovedNotification($job));

        return response()->json([
            'success' => true,
            'message' => 'Tin đã được duyệt.',
            'status_html' => $job->status_badge,
        ]);
    }

   public function reject(Request $request, Job $job)
{
    if ($job->status !== 'pending') {
        $job->refresh();
        return response()->json([
            'success' => false,
            'message' => 'Tin đã được xử lý bởi người khác.',
            'status_html' => $job->status_badge,
        ], 409);
    }

    // Cập nhật trạng thái
    $job->update(['status' => 'rejected']);

    // Gửi thông báo cho nhà tuyển dụng
    $employer = $job->company->user;
    
    $employer->notify(new JobRejectedNotification($job));

    return response()->json([
        'success' => true,
        'message' => 'Tin đã bị từ chối và đã gửi thông báo.',
        'status_html' => $job->status_badge,
    ]);
}



    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Tin tuyển dụng đã bị xoá.');
    }
}
