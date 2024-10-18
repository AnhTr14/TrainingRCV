<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:mst_users,email',
            'password' => 'required|min:3',
            'group_role' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được trống',
            'email.required' => 'Email không được trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => "Mật khẩu không được trống",
            'password.min' => 'Mật khẩu có ít nhất 3 ký tự',
            'group_role.required' => "Nhóm không được trống",
        ];
    } 
}
