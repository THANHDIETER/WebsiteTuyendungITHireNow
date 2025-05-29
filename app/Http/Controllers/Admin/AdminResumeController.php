<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;


class AdminResumeController extends Controller
{
    public function index()
    {
        try {
            $resumes = Resume::where('is_approved', false)->get();
            return response()->json($resumes, 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Lỗi khi lấy danh sách hồ sơ', 'error' => $e->getMessage()], 500);
        }
    }

    public function approve($id)
    {
        try {
            $resume = Resume::findOrFail($id);
            $resume->is_approved = true;
            $resume->save();

            return response()->json(['message' => 'Đã duyệt thành công'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Không tìm thấy hồ sơ'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Duyệt thất bại', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $resume = Resume::findOrFail($id);
            $resume->delete();

            return response()->json(['message' => 'Đã xóa thành công'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Không tìm thấy hồ sơ'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Xóa thất bại', 'error' => $e->getMessage()], 500);
        }
    }

}