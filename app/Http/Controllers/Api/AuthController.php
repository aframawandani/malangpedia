<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PostLoginRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function postLogin(PostLoginRequest $request)
    {
        $login_data = $request->validated();
    }

    public function user(Request $request)
    {
        $user = $request->user();

        if (is_null($user))
        {
            return response()->json(null, 401);
        }

        return new UserResource($user);
    }
}
