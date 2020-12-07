<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class Category extends Model
{
    protected $table = 'categories';

    public $primaryKey = 'category_id';

    protected $fillable = [
        'parent_category_id',
        'name',
        'slug',
        'description',
        'image',
        'sort_order',
        'status'
    ];

    public static function boot() {
        parent::boot();

        static::creating(function (Category $category)
        {
            $request = request();

            if (is_null($category->slug))
            {
                $category->slug = slugify($category->name);
            }

            $category->owner_user_id = $request->user()->id;
        });
    }

    public function products()
    {
        return $this->hasManyThrough('App\Models\Product', 'App\Models\Product_2_category', 'category_id', 'product_id', 'category_id', 'product_id');
    }
}
