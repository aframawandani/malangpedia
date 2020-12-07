<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weight_class extends Model
{
    use HasFactory;

    protected $table = 'weight_classes';

    public $primaryKey = 'weight_class_id';

    protected $fillable = [
        'name'
    ];
}
