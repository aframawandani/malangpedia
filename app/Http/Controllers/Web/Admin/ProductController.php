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

    public function update()
    {
        return Inertia::render('Admin/Product/Update');
    }
}
