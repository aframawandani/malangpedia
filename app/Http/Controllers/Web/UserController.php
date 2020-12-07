<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\User\GetIndexRequest;
use App\Http\Requests\Web\User\GetCreateRequest;
use App\Http\Requests\Web\User\GetUpdateRequest;

class UserController extends Controller
{
    public function index(GetIndexRequest $request)
    {
        return Inertia::render('User/Index');
    }

    public function create(GetCreateRequest $request)
    {
        return Inertia::render('User/Create');
    }

    public function update(GetUpdateRequest $request)
    {
        return Inertia::render('User/Update');
    }
}
