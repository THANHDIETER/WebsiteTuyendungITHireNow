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
        $title = 'Danh sách tin tuyển dụng';
        $query = Job::with(['company', 'categories', 'skills']);

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

        return view('admin.jobs.index', compact('jobs', 'categories', 'title'));
    }

    public function show($id)
{
    $job = Job::with([
        'company',
        'categories',
        'skills',
        'jobType',
        'level',
        'experience',
        'language',
        'remotePolicy',
        'location',
        
        
    ])->find($id);

    if (!$job) {
        return response()->json([
            'success' => false,
            'message' => 'Tin tuyển dụng không tồn tại.',
        ], 404);
    }

    return view('admin.jobs.show', compact('job'));
}


    public function approve(Request $request, $id)
    {
        // kiểm tra xem job có tồn tại không 
        $job = Job::find($id);

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => 'Tin tuyển dụng không tồn tại.',
            ], 404);
        }
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



        $job->update(['status' => 'rejected']);
        // Gửi thông báo cho nhà tuyển dụng
        $employer = $job->company->user;

        $employer->notify(new JobRejectedNotification($job));

        return response()->json([
            'success' => false,
            'message' => 'Tin đã được xử lý bởi người khác.',
            'status_html' => $job->status_badge,
        ], 409);
    }






    public function destroy($id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => 'Tin tuyển dụng không tồn tại.',
            ], 404);
        }

        $job->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tin tuyển dụng đã được xoá.'
        ]);
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



    public function revertToPending(Request $request, $id)
    {

        $job = Job::find($id);

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => 'Tin tuyển dụng không tồn tại.',
            ], 404);
        }

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
