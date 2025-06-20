<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;

class BankAccountController extends Controller
{
    public function index()
    {
        try {
            return response()->json(BankAccount::all());
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Không thể lấy danh sách tài khoản ngân hàng.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'bank' => 'required|string',
                'account_number' => 'required|string',
                'account_name' => 'required|string|max:255', 
                'token' => 'required|string',
                'password' => 'required|string',
                'branch' => 'required|string|max:255',
                'is_active' => 'required|boolean',
                'image' => 'required|image|mimes:jpeg,png,jpg,webp,gif,svg|max:100000',
            ],[
                'account_name.required' => 'Tên chủ tài khoản là bắt buộc.',
                'bank.required' => 'Tên ngân hàng là bắt buộc.',
                'account_number.required' => 'Số tài khoản là bắt buộc.',
                'token.required' => 'Token là bắt buộc.',
                'password.required' => 'Mật khẩu là bắt buộc.',
                'branch.required' => 'Chi nhánh là bắt buộc.',
                'is_active.required' => 'Trạng thái hoạt động là bắt buộc.',
                'image.required' => 'Ảnh đại diện là bắt buộc.',
                'image.image' => 'Ảnh đại diện phải là một tệp hình ảnh.',
                'image.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg hoặc webp.',
                'image.max' => 'Ảnh đại diện không được vượt quá 2MB.'

            ]);

            $data['is_active'] = $data['is_active'] ?? 1;

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('bank-images', 'public');
            }

            $exists = BankAccount::where('bank', $data['bank'])
                ->where('account_number', $data['account_number'])
                ->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'Tài khoản ngân hàng này đã tồn tại.'
                ], 409);
            }

            $account = BankAccount::create($data);
            return response()->json($account, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Lỗi khi tạo tài khoản ngân hàng.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        try {
            $data = $request->validate([
                'bank' => 'required|string',
                'account_number' => 'required|string',
                'account_name' => 'required|string|max:255',
                'token' => 'required|string',
                'password' => 'required|string',
                'branch' => 'required|string|max:255',
                'is_active' => 'required|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg|max:10000',
            ],[
                'account_name.required' => 'Tên chủ tài khoản là bắt buộc.',
                'bank.required' => 'Tên ngân hàng là bắt buộc.',
                'account_number.required' => 'Số tài khoản là bắt buộc.',
                'token.required' => 'Token là bắt buộc.',
                'password.required' => 'Mật khẩu là bắt buộc.',
                'branch.required' => 'Chi nhánh là bắt buộc.',
                'is_active.required' => 'Trạng thái hoạt động là bắt buộc.',
                'image.required' => 'Ảnh đại diện là bắt buộc.',
                'image.image' => 'Ảnh đại diện phải là một tệp hình ảnh.',
                'image.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg hoặc webp.',
                'image.max' => 'Ảnh đại diện không được vượt quá 2MB.'
            ]);

            $data['is_active'] = $data['is_active'] ?? 0;

            // Nếu có file ảnh gửi lên, xoá ảnh cũ và lưu ảnh mới
            if ($request->hasFile('image')) {
                if ($bankAccount->image) {
                    Storage::disk('public')->delete($bankAccount->image);
                }
                $data['image'] = $request->file('image')->store('bank-images', 'public');
            }

            $bankAccount->update($data);

            return response()->json($bankAccount);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Lỗi khi cập nhật tài khoản ngân hàng.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy(BankAccount $bankAccount)
    {
        try {
            if ($bankAccount->image) {
                Storage::disk('public')->delete($bankAccount->image);
            }

            $bankAccount->delete();
            return response()->json(['message' => 'Xoá tài khoản thành công']);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Không thể xoá tài khoản.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
