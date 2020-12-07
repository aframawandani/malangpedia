<?php

namespace App\Http\Controllers\Web;

use Inertia\Inertia;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Product/Index');
    }

    public function single()
    {
        return Inertia::render('Product/Single');
    }
}
