<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Xác định người dùng có quyền gửi request này hay không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Quy tắc kiểm tra dữ liệu đầu vào.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|same:password',
            'role' => 'required|in:job_seeker,employer',
        ];
    }

    /**
     * Thông báo lỗi tuỳ chỉnh.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email là trường bắt buộc.',
            'email.string' => 'Email phải là một chuỗi ký tự.',
            'email.email' => 'Email phải có định dạng hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'email.unique' => 'Email này đã được sử dụng, vui lòng chọn email khác.',

            'password.required' => 'Mật khẩu là trường bắt buộc.',
            'password.string' => 'Mật khẩu phải là một chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',

            'confirm_password.required' => 'Xác nhận mật khẩu là trường bắt buộc.',
            'confirm_password.string' => 'Xác nhận mật khẩu phải là một chuỗi ký tự.',
            'confirm_password.same' => 'Xác nhận mật khẩu phải khớp với mật khẩu.',

            'role.required' => 'Vai trò là trường bắt buộc.',
            'role.in' => 'Vai trò chỉ được phép là job_seeker hoặc employer.',
        ];
    }
}
