<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shopping_cart_product extends Model
{
    protected $table = 'shopping_cart_products';

    public $primaryKey = 'shopping_cart_product_id';

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];
}
