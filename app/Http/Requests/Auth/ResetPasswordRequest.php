<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'password' => 'required|min:8|regex:/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/',
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Password harus diisi',  
            'password.min' => 'Password minimal 8 karakter',
            'password.regex' => 'Password harus terdiri dari huruf kecil, huruf besar, dan angka',
            'password_confirmation.required' => 'Konfirmasi password harus diisi',
            'password_confirmation.same' => 'Konfirmasi password tidak sesuai',
        ];
    }
}
