<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|regex:/^[^@]+@[^@]+\.[^@]+$/',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email không được trống',
            'email.email' => 'Email không đúng định dạng',
            'email.regex' => 'Email không đúng định dạng',
            'password.required' => "Mật khẩu không được trống",
        ];
    } 
}
