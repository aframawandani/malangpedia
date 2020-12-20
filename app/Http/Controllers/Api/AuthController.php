<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
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
