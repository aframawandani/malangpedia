<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Admin/Category/Index');
    }

    public function insert(Request $request)
    {
        return Inertia::render('Admin/Category/Insert');
    }

    public function update(Request $request, $category_id)
    {
        return Inertia::render('Admin/Category/Update')->with(['category_id' => $category_id]);
    }
}
