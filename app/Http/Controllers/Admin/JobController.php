<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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


        $job->update(['status' => 'published']);
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

        $job->update(['status' => 'rejected']);

        return response()->json([
            'success' => true,
            'message' => 'Tin đã bị từ chối.',
            'status_html' => $job->status_badge,

        ]);
    }


    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Tin tuyển dụng đã bị xoá.');
    }

    public function revertToPending(Request $request, Job $job)
    {
        // Chỉ cho phép revert nếu trạng thái là published hoặc closed
        if (!in_array($job->status, ['published', 'closed'])) {
            return response()->json([
                'success' => false,
                'message' => 'Trạng thái hiện tại không thể khôi phục về pending.',
                'status_html' => $job->status_badge,
            ], 409);
        }

        // Kiểm tra nếu đã quá 5 phút kể từ khi cập nhật
        if ($job->updated_at->diffInMinutes(now()) > 5) {
            return response()->json([
                'success' => false,
                'message' => 'Tin đã đăng quá 5 phút nên không thể khôi phục.',
                'status_html' => $job->status_badge,
            ]);
        }

        // Cập nhật lại trạng thái
        $job->update(['status' => 'pending']);

        return response()->json([
            'success' => true,
            'message' => 'Tin đã được khôi phục về trạng thái chờ duyệt.',
            'status_html' => $job->status_badge,
        ]);
    }


}
