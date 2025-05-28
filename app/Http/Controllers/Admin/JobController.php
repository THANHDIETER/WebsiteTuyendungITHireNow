<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobController extends Controller
{


    // Lấy danh sách các job chưa duyệt
    public function index()
    {
        $jobs = JobPost::where('is_approved', false)->with('company')->get();
        return view('admin.jobs.index', compact('jobs'));
    }

    // Duyệt tin tuyển dụng
    public function approve($id)
    {
        $job = JobPost::findOrFail($id);
        $job->update(['is_approved' => true]);
        return redirect()->back()->with('success', value: 'Tin tuyển dụng đã được duyệt thành công.');
    }

    // Xóa tin tuyển dụng
    public function destroy($id)
    {
        $job = JobPost::findOrFail($id);
        $job->delete();
        return redirect()->back()->with('success', 'Tin tuyển dụng đã bị xóa thành công.');
    }
}