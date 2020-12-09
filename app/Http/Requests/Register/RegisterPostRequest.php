<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;

class RegisterPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|in:1,2',
            'password' => 'required|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'gender.required' => 'Jenis Kelamin harus diisi',
            'gender.in' => 'Jenis Kelamin tidak valid',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Password harus sama dengan Password Konfirmasi'
        ];
    }
}
