<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role_2_permission extends Model
{
    protected $table = 'role_2_permissions';

    public $primaryKey = 'role_2_permission_id';

    protected $fillable = [
        'role_id',
        'permission_id'
    ];
}
