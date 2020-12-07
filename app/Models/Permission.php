<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    public $primaryKey = 'permission_id';

    protected $fillable = [
        'name',
        'description'
    ];
}
