<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    public $primaryKey = 'product_id';

    protected $fillable = [
        'owner_user_id',
        'upc',
        'name',
        'description',
        'slug',
        'image',
        'quantity',
        'minimum_quantity',
        'subtract',
        'weight',
        'weight_class_id',
        'length',
        'width',
        'height',
        'price',
        'viewed',
        'sort_order',
        'status'
    ];

    public function categories()
    {
        $this->hasManyThrough('App\Models\Category', 'App\Models\Product', 'product_id', 'category_id', 'product_id', 'category_id');
    }
}
