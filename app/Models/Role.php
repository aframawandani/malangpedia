<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public $primaryKey = 'role_id';

    protected $fillable = [
        'name',
        'description'
    ];

    public function permissions()
    {
        return $this->hasManyThrough('App\Models\Permission', 'App\Models\Role_2_permission', 'role_id', 'permission_id', 'role_id', 'permission_id');
    }
}
