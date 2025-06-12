<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeekerProfile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class SeekerProfileController extends Controller
{

    public function index(Request $request)
    {
        $query = SeekerProfile::with('user')->orderByDesc('created_at');

        if ($request->has('is_visible')) {
            $query->where('is_visible', $request->input('is_visible'));
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $search . '%'));
        }

        return response()->json($query->paginate($request->input('per_page', 10)));
    }



    public function show($id)
    {
        try {
            $profile = SeekerProfile::with('user')->findOrFail($id);
            return response()->json($profile);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Không tìm thấy hồ sơ'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Đã xảy ra lỗi'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $profile = SeekerProfile::findOrFail($id);

            $data = $request->validate([
                'headline' => 'sometimes|max:150',
                'summary' => 'sometimes',
                'cv_url' => 'sometimes|url',
                'linkedin_url' => 'nullable|url',
                'github_url' => 'nullable|url',
                'portfolio_url' => 'nullable|url',
                'location' => 'nullable|string',
                'salary_expectation' => 'nullable|integer',
                'years_of_experience' => 'nullable|integer',
                'job_types' => 'nullable|string',
                'education' => 'nullable|string',
                'work_experience' => 'nullable|string',
                'language_skills' => 'nullable|string',
                'is_visible' => 'nullable|boolean'
            ]);

            if (
                isset($data['is_visible']) &&
                $profile->is_visible === true &&
                $data['is_visible'] === false
            ) {
                return response()->json([
                    'error' => 'Hồ sơ đã được duyệt không thể bị từ chối lại.'
                ], 403);
            }

            $profile->update($data);

            return response()->json([
                'message' => 'Hồ sơ đã được cập nhật',
                'profile' => $profile
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Không tìm thấy hồ sơ'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Lỗi cập nhật hồ sơ'], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $profile = SeekerProfile::findOrFail($id);
            $profile->delete();

            return response()->json(['message' => 'Hồ sơ đã bị xoá']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Không tìm thấy hồ sơ'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Không thể xoá hồ sơ'], 500);
        }
    }
}
