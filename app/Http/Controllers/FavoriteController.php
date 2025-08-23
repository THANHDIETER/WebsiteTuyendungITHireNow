<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $favorites = $user->favoriteJobs()->with('company')->latest()->paginate(10);

        return view('website.jobs.favorites', compact('favorites'));
    }


    public function store($jobId)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Bạn cần đăng nhập'], 401);
        }

        $user = Auth::user();

        // Kiểm tra job có tồn tại không
        $job = Job::findOrFail($jobId);

        // Kiểm tra đã lưu chưa
        $alreadySaved = $user->favoriteJobs()->where('job_id', $jobId)->exists();

        if ($alreadySaved) {
            // Nếu đã lưu thì bỏ lưu (toggle)
            $user->favoriteJobs()->detach($jobId);
            return response()->json([
                'message' => 'Đã bỏ lưu việc làm.',
                'favorited' => false
            ]);
        }

        // Nếu chưa lưu thì thêm vào favorites
        $user->favoriteJobs()->attach($jobId, ['note' => 'Yêu thích']);
        return response()->json([
            'message' => 'Đã lưu việc làm.',
            'favorited' => true
        ]);
    }
    public function destroy(Job $job)
    {
        Auth::user()->favoriteJobs()->detach($job->id);
        return back()->with('success', 'Đã bỏ yêu thích');
    }
        public function show($id)
    {
       $job = Job::with(['company', 'jobType', 'level', 'experience', 'jobLanguage', 'remotePolicy', 'location'])
          ->findOrFail($id);

        return response()->json([
            'title'       => $job->title,
            'company'     => $job->company->name ?? null,
            'type'        => $job->jobType->name ?? null,
            'level'       => $job->level->name ?? null,
            'experience'  => $job->experience->name ?? null,
            'language'    => $job->jobLanguage->name ?? null,
            'remote'      => $job->remotePolicy->name ?? null,
            'location'    => $job->location->name ?? null,
            'salary'      => $job->salary_min . ' - ' . $job->salary_max . ' ' . $job->currency,
            'deadline'    => $job->deadline ? $job->deadline->format('d/m/Y') : null,
            'description' => $job->description,
            'requirements'=> $job->requirements,
            'benefits'    => $job->benefits,
        ]);

    }

}
