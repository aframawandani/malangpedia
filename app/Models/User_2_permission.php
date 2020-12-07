<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_2_permission extends Model
{
    protected $table = 'user_2_permissions';

    public $primaryKey = 'user_2_permission_id';

    protected $fillable = [
        'user_id',
        'permission_id'
    ];
}
