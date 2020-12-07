<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    public $primaryKey = 'order_id';

    protected $fillable = [
        'user_id',
        'address',
        'note',
        'status'
    ];

    public function order_2_product()
    {
        return $this->hasMany('App\Models\Order_2_product', 'order_id', 'order_id');
    }
}
