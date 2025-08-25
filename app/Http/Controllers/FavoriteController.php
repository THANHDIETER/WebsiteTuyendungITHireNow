<?php
namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()
            ->favoriteJobs()
            ->with('company')
            ->paginate(9);

        // Cache gợi ý jobs trong 10 phút (dữ liệu array)
        $suggestedJobs = Cache::remember('suggested_jobs', 600, function () {
            // Lấy 10 công ty mới nhất
            $companyIds = Job::select('company_id')
                ->whereNotNull('company_id')
                ->orderByDesc('created_at')
                ->distinct()
                ->limit(10)
                ->pluck('company_id');

            // Query join để lấy job mới nhất của mỗi công ty
            $jobs = Job::join(
                DB::raw('(SELECT company_id, MAX(id) as max_id FROM jobs GROUP BY company_id) j2'),
                function ($join) {
                    $join->on('jobs.id', '=', 'j2.max_id');
                }
            )
                ->whereIn('jobs.company_id', $companyIds)
                ->with(['company', 'location'])
                ->orderByDesc('jobs.created_at')
                ->get(['jobs.*']);

            // Chuyển thành array thuần để cache
            return $jobs->map(function ($job) {
                return [
                    'id' => $job->id,
                    'title' => $job->title,
                    'slug' => $job->slug,
                    'salary' => $job->salary_min . ' - ' . $job->salary_max . ' ' . $job->currency,
                    'date' => $job->created_at->format('d/m/Y'),
                    'company' => [
                        'name' => $job->company->name ?? 'Công ty',
                        'logo' => $job->company->logo_url
                            ? asset('storage/' . $job->company->logo_url)
                            : asset('client/assets/img/default-company.png'),
                    ],
                    'location' => $job->location->name ?? 'Địa điểm',
                ];
            })->toArray();
        });

        return view('website.jobs.favorites', compact('favorites', 'suggestedJobs'));
    }

    // Thêm hoặc bỏ lưu (toggle)
    public function store($jobId)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Bạn cần đăng nhập'], 401);
        }

        $user = Auth::user();
        $job = Job::findOrFail($jobId);

        $alreadySaved = $user->favoriteJobs()->where('job_id', $jobId)->exists();

        if ($alreadySaved) {
            $user->favoriteJobs()->detach($jobId);
            return response()->json(['message' => 'Đã bỏ lưu việc làm.', 'favorited' => false]);
        }

        $user->favoriteJobs()->attach($jobId, ['note' => 'Yêu thích']);
        return response()->json(['message' => 'Đã lưu việc làm.', 'favorited' => true]);
    }

    // Xóa bằng AJAX
    public function destroy($jobId)
    {
        $user = Auth::user();
        $user->favoriteJobs()->detach($jobId);

        return response()->json(['success' => true, 'message' => 'Đã bỏ yêu thích']);
    }
}

