<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class PostLoginRequest extends FormRequest
{
    public $user;

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
            'email' => 'required|email',
            'password' => 'required',
            '_email' => Rule::requiredIf(function ()
            {
                $email = $this->get('email');
                $this->user = User::where('email', $email)->get()->first();

                if (is_null($this->user))
                {
                    return true;
                }

                return false;
            }),
            '_password' => Rule::requiredIf(function ()
            {
                if (Auth::attempt($login_data))
                {
                    Auth::login($this->user);

                    return false;
                }

                return false;
            })
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email harus diisi',
            '_email.required' => 'Email tidak valid',
            'password.required' => 'Password harus diisi'
        ];
    }
}
