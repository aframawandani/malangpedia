<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use League\Glide\Server;
use App\Traits\Permission;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use SoftDeletes, Authenticatable, Authorizable, Permission;

    protected $casts = [
        'owner' => 'boolean',
    ];

    public function roles()
    {
        return $this->hasManyThrough('App\Models\Role', 'App\Models\User_2_role', 'user_id', 'role_id', 'id', 'role_id');
    }

    public function permissions()
    {
        return $this->hasManyThrough('App\Models\Permission', 'App\Models\User_2_permission', 'user_id', 'permission_id', 'id', 'permission_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
