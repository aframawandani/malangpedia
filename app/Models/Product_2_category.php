<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_2_category extends Model
{
    protected $table = 'product_2_categories';

    public $primaryKey = 'product_2_category_id';

    protected $fillable = [
        'product_id',
        'category_id'
    ];
}
