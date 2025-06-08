<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterEmployerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Thông tin liên lạc
            'full_name' => 'required|string|max:255',
            'work_title' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',

            // Kinh nghiệm biết đến HireNow
            'itvie_experience' => 'nullable|string|in:google,facebook,khac',

            // Thông tin công ty
            'company_name' => 'required|string|max:255',
            'company_location' => 'required|in:hanoi,hcm,danang,khac',
            'website_url' => 'nullable|url',

            // Mật khẩu
            'password' => 'required|string|min:6|confirmed',

            // Đồng ý điều khoản
            'terms' => 'accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'terms.accepted' => 'Bạn phải đồng ý với Điều khoản & Chính sách để tiếp tục.',
        ];
    }
}
