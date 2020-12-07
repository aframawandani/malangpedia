<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_2_role extends Model
{
    protected $table = 'user_2_roles';

    public $primaryKey = 'user_2_role_id';

    protected $fillable = [
        'user_id',
        'role_id'
    ];
}
