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
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            // 未入力の場合
            'name.required' => 'お名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'password.required' => 'パスワードを入力してください',

            // メール形式のエラー
            'email.email' => 'メールアドレスはメール形式で入力してください',

            // パスワードの入力規則違反
            'password.min' => 'パスワードは8文字以上で入力してください',

            // 確認用パスワードの一致違反
            'password.confirmed' => 'パスワードと一致しません',
        ];
    }
}