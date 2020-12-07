<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Category/Index');
    }

    public function insert()
    {
        return Inertia::render('Admin/Category/Insert');
    }

    public function update()
    {
        return Inertia::render('Admin/Category/Update');
    }
}
