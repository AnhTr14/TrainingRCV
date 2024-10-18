<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:mst_users,email|regex:/^[^@]+@[^@]+\.[^@]+$/',
            'password' => 'required|min:3',
            'role' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'email.regex' => 'Email không đúng định dạng',
            'password.required' => "Vui lòng nhập mật khẩu",
            'password.min' => 'Mật khẩu có ít nhất 3 ký tự',
            'role.required' => "Vui lòng chọn nhóm",
        ];
    } 
}
