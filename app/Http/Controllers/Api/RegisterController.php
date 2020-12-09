<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\Register\RegisterPostRequest;
use App\Http\Controllers\Controller;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(RegisterPostRequest $request)
    {
        $auth = auth();
        $register_data = $request->validated();

        User::create($register_data);

        dump(Auth::attempt([
            'email' => $register_data['email'],
            'password' => $register_data['password']
        ]));        
    }
}
