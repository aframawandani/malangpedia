<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';

    public $primaryKey = 'gallery_id';

    protected $fillable = [
        'product_id',
        'image',
        'order'
    ];
}
