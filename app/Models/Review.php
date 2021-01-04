<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    public $primaryKey = 'review_id';

    protected $fillable = [
        'user_id',
        'product_id',
        'content',
        'rating'
    ];
}
