<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class SavedJobController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh sách việc đã lưu của user hiện tại, phân trang
        $jobs = $request->user()->savedJobs()->paginate(9);
        return view('website.jobs.saved', compact('jobs'));
    }

    public function toggle(Request $request, Job $job)
    {
        $user = $request->user();

        // Nếu đã lưu thì bỏ, chưa lưu thì lưu
        if ($user->savedJobs()->where('job_id', $job->id)->exists()) {
            $user->savedJobs()->detach($job->id);
            session()->flash('status', 'Đã bỏ lưu việc này.');
        } else {
            $user->savedJobs()->attach($job->id);
            session()->flash('status', 'Đã lưu việc này.');
        }

        return back();
    }
}

