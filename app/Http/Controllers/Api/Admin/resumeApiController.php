<?php

namespace App\Http\Controllers\api\Admin;

use Exception;
use App\Models\Resume;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class resumeApiController extends Controller
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

    public function update($id)
    {
        try {
            DB::beginTransaction();

            $resume = Resume::where('id', $id)->lockForUpdate()->firstOrFail();

            if ($resume->is_approved) {
                DB::rollBack();
                return response()->json(['message' => 'Hồ sơ đã được duyệt trước đó'], 400);
            }

            $resume->is_approved = true;
            $resume->save();

            DB::commit();
            return response()->json(['message' => 'Đã duyệt thành công'], 200);

        } catch (AuthorizationException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Không có quyền duyệt hồ sơ'], 403);

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Không tìm thấy hồ sơ'], 404);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Duyệt thất bại',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $resume = Resume::where('id', $id)->lockForUpdate()->firstOrFail();

            if ($resume->is_approved) {
                DB::rollBack();
                return response()->json(['message' => 'Không thể xóa hồ sơ đã được duyệt'], 400);
            }

            $resume->delete();
            DB::commit();

            return response()->json(['message' => 'Đã xóa hồ sơ thành công'], 200);

        } catch (AuthorizationException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Không có quyền xóa hồ sơ'], 403);

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Hồ sơ không tồn tại hoặc đã bị xóa'], 404);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Xóa thất bại',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
