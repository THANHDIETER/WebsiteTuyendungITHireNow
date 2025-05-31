<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255|unique:users',
            'password_hash' => 'required|string|min:8',
            'confirm_password' => 'required|string|same:password_hash',
            'role' => 'required|in:job_seeker,employer',
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

            'password_hash.required' => 'Mật khẩu là trường bắt buộc.',
            'password_hash.string' => 'Mật khẩu phải là một chuỗi ký tự.',
            'password_hash.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',

            'confirm_password.required' => 'Xác nhận mật khẩu là trường bắt buộc.',
            'confirm_password.string' => 'Xác nhận mật khẩu phải là một chuỗi ký tự.',
            'confirm_password.same' => 'Xác nhận mật khẩu phải khớp với mật khẩu.',

            'role.required' => 'Vai trò là trường bắt buộc.',
            'role.in' => 'Vai trò phải là job_seeker hoặc employer.',
        ];
    }
}
