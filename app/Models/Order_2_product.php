<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_2_product extends Model
{
    protected $table = 'order_2_products';

    public $primaryKey = 'order_id';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity'
    ];
}
