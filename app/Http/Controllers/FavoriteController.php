<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
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
}
