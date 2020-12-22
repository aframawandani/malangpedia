<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Product/Index');
    }

    public function insert()
    {
        return Inertia::render('Admin/Product/Insert');
    }

    public function update(Request $request, $product_id)
    {
        return Inertia::render('Admin/Product/Update')->with('productId', intval($product_id));
    }
}
