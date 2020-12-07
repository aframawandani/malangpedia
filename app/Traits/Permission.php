<?php

namespace App\Traits;

use App\Models\User_2_permission;
use App\Models\User_2_role;

Trait Permission
{
    public function HasPermission(string $permission)
    {
        return is_object(
            User_2_role
            ::select('permissions.permission_id')
            ->where('user_2_roles.user_id', $this->id)
            ->leftJoin('role_2_permissions', 'role_2_permissions.role_id', '=', 'user_2_roles.user_id')
            ->leftJoin('permissions', 'permissions.permission_id', '=', 'role_2_permissions.permission_id')
            ->where('permissions.name', $permission)
            ->get()->first()
        ) ||
        is_object(
            User_2_permission
            ::select('permissions.permission_id')
            ->leftJoin('permissions', 'permissions.permission_id', '=', 'user_2_permissions.permission_id')
            ->where('user_2_permissions.user_id', $this->id)
            ->where('permissions.name', $permission)
            ->get()
            ->first()
        );
    }
}
