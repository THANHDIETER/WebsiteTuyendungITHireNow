<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'role' => 'sometimes|in:job_seeker,employer',
        ];
    }

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
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',

            'password_confirmation.required' => 'Xác nhận mật khẩu là trường bắt buộc.',
            'password_confirmation.string' => 'Xác nhận mật khẩu phải là một chuỗi ký tự.',
            'password_confirmation.min' => 'Xác nhận mật khẩu phải có ít nhất 8 ký tự.',

            'role.in' => 'Vai trò chỉ được phép là job_seeker hoặc employer.',
        ];
    }
}
