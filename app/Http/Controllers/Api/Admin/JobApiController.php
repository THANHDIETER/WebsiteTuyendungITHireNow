<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobApiController extends Controller
{
    // Lấy danh sách tin tuyển dụng chưa duyệt
    public function index()
    {
        $jobs = JobPost::where('is_approved', false)->with('company')->get();

        return response()->json([
            'status' => true,
            'message' => 'Danh sách tin chưa duyệt',
            'data' => $jobs
        ]);
    }

    // Duyệt tin tuyển dụng
    public function approve($id)
    {
        $job = JobPost::find($id);

        if (!$job) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy tin tuyển dụng.'
            ], 404);
        }

        $job->is_approved = true;
        $job->save();

        return response()->json([
            'status' => true,
            'message' => 'Tin tuyển dụng đã được duyệt thành công.'
        ]);
    }

    // Xóa tin tuyển dụng
    public function destroy($id)
    {
        $job = JobPost::find($id);

        if (!$job) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy tin tuyển dụng.'
            ], 404);
        }

        $job->delete();

        return response()->json([
            'status' => true,
            'message' => 'Tin tuyển dụng đã bị xóa thành công.'
        ]);
    }
}
