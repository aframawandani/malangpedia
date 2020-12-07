<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\GetRequest;
use App\Http\Requests\Api\User\PutRequest;
use App\Http\Requests\Api\User\PatchRequest;
use App\Http\Requests\Api\User\DeleteRequest;
use App\Models\User;

class UserController extends Controller
{
    public function get(GetRequest $request)
    {
        $user_builder =
        User
        ::with([
        'roles' => function ($query)
        {
            $query
            ->select('roles.role_id', 'roles.name', 'roles.description')
            ->with([
                'permissions' => function ($query)
                {
                    $query->select('permissions.permission_id', 'permissions.name', 'permissions.description');
                }
            ]);
        }])
        ->with([
            'permissions' => function ($query)
            {
                $query->select('permissions.permission_id', 'permissions.name', 'permissions.description');
            }
        ])
        ->select('users.id', 'users.first_name', 'users.last_name');

        return Datatables::of($user_builder)->toJson();
    }

    public function put(PutRequest $request)
    {}
}
