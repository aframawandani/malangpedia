<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login()
    {
        return Inertia::render('Auth/Login/Index');
    }
}
