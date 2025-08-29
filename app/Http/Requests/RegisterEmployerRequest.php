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
            'full_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\p{L}\s]+$/u', // chỉ cho phép chữ và khoảng trắng
            ],
            'email' => 'required|email|unique:users,email',
            'phone' => [
                'required',
                'regex:/^(0[1-9][0-9]{8,9})$/', // chuẩn số ĐT VN (10-11 số, bắt đầu bằng 0)
            ],
            'company_name' => 'required|string|max:255',
            'city_id' => 'required|exists:locations,id',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Vui lòng nhập họ và tên.',
            'full_name.regex' => 'Họ và tên chỉ được chứa chữ cái và khoảng trắng.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập đúng định dạng (VD: 0912345678).',
            'company_name.required' => 'Vui lòng nhập tên công ty.',
            'city_id.required' => 'Vui lòng chọn thành phố.',
            'city_id.exists' => 'Thành phố không hợp lệ.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
            'terms.accepted' => 'Bạn phải đồng ý với điều khoản và chính sách.',
        ];
    }
}
